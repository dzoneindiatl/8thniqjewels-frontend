<?php

namespace App\Http\Controllers\Front;

use Exception;
use Session, Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\WalletHistory;
use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\ProductVariantCombination;
use App\Helpers\SequelShippingHelper;
use App\Models\{ProductGraphics, VariantValue, OrderStatusHistory, OrderCancellation, RefundRequest};

class OrderController extends Controller
{

    public function orderDetails(Request $request, $orderId)
    {
        $orderDetails = Order::where('id', $orderId)->firstOrFail();
       
        $allStatuses = OrderStatus::orderBy('step')->where('active', 1)->get();
        
        $paymentMode = match ($orderDetails->payment_method) {
            'cod' => 'Cash On Delivery',
            'paypal', 'razorpay' => 'Pay Online',
            default => 'Wallet',
        };
       
        $orderItems = OrderItem::with(['product', 'order', 'productGraphics', 'statusHistoriesItem'])
            ->whereHas('order', function ($query) use ($orderId) {
                $query->where('id', $orderId);
            })->get();
        // @dd($orderItems);

        $OrderStatusHistory = OrderStatusHistory::where('order_id', $orderId)->get();
       
        $html = view('front.modules.dashboard.order-details', compact('orderDetails', 'orderItems','paymentMode', 'allStatuses','OrderStatusHistory'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
        ]);
    }

    public function createBalancePaymentLinkWhenShipped(Request $request, $orderNumber)
    {
        $token = config('services.admin_order_status_token');
        $providedToken = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Admin order status integration is not configured.'], 503);
        }
        if (!$providedToken || !hash_equals($token, $providedToken)) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        if ($order->status !== 'shipped') {
            return response()->json(['message' => 'The order must be marked shipped before creating its balance payment link.'], 409);
        }
        if ((float) $order->pending_amount <= 0) {
            return response()->json(['message' => 'This order has no outstanding balance.'], 422);
        }

        $customer = $order->user;
        if (!$customer || !$customer->email) {
            return response()->json(['message' => 'The customer has no email address for the payment link.'], 422);
        }

        if (!$order->balance_payment_link_id || !$order->balance_payment_link_url) {
            $mode = config('services.razorpay.mode', 'live');
            $key = config("services.razorpay.{$mode}_key");
            $secret = config("services.razorpay.{$mode}_secret");
            if (!$key || !$secret) {
                return response()->json(['message' => 'Razorpay credentials are not configured.'], 503);
            }

            $paymentLinkEndpoint = rtrim(env('RAZORPAY_DEFAULT_URL', 'https://api.razorpay.com/v1/'), '/') . '/payment_links';
            $paymentLinkResponse = Http::withBasicAuth($key, $secret)
                ->acceptJson()
                ->post($paymentLinkEndpoint, [
                    'amount' => (int) round((float) $order->pending_amount * 100),
                    'currency' => 'INR',
                    'accept_partial' => false,
                    'reference_id' => $order->order_number,
                    'description' => 'Remaining balance for order ' . $order->order_number,
                    'customer' => [
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'contact' => $customer->phone_number,
                    ],
                    'notify' => ['email' => true, 'sms' => false],
                    'reminder_enable' => false,
                    'callback_url' => route('balance-payment.callback'),
                    'callback_method' => 'get',
                    'notes' => ['order_id' => (string) $order->id],
                ]);

            if (!$paymentLinkResponse->successful()) {
                Log::error('Razorpay balance payment link creation failed.', [
                    'order_id' => $order->id,
                    'status' => $paymentLinkResponse->status(),
                    'response' => $paymentLinkResponse->json(),
                ]);
                return response()->json(['message' => 'Unable to create the Razorpay balance payment link.'], 502);
            }

            $paymentLink = $paymentLinkResponse->json();
            if (empty($paymentLink['id']) || empty($paymentLink['short_url'])) {
                Log::error('Razorpay returned an incomplete balance payment link.', [
                    'order_id' => $order->id,
                    'response' => $paymentLink,
                ]);
                return response()->json(['message' => 'Razorpay returned an incomplete payment link.'], 502);
            }

            $order->balance_payment_link_id = $paymentLink['id'];
            $order->balance_payment_link_url = $paymentLink['short_url'];
            $order->save();
        }

        Mail::send('emails.balance-payment-link', [
            'customerName' => $customer->name,
            'orderNumber' => $order->order_number,
            'balanceAmount' => (float) $order->pending_amount,
            'currency' => '₹',
            'paymentUrl' => $order->balance_payment_link_url,
        ], function ($message) use ($customer, $order) {
            $message->to($customer->email)
                ->subject('Payment due for shipped order ' . $order->order_number);
        });

        return response()->json([
            'message' => 'Balance payment link created and emailed.',
            'order_number' => $order->order_number,
            'balance_due' => (float) $order->pending_amount,
            'payment_url' => $order->balance_payment_link_url,
        ]);
    }

    public function balancePaymentCallback(Request $request)
    {
        $paymentLinkId = (string) $request->query('razorpay_payment_link_id', '');
        $referenceId = (string) $request->query('razorpay_payment_link_reference_id', '');
        $paymentId = (string) $request->query('razorpay_payment_id', '');
        $paymentStatus = (string) $request->query('razorpay_payment_link_status', '');
        $signature = (string) $request->query('razorpay_signature', '');
        $secret = $this->razorpayApiSecret();

        if (!$secret) {
            abort(503, 'Razorpay is not configured.');
        }
        if (!$paymentLinkId || !$referenceId || !$paymentId || !$signature) {
            abort(400, 'Missing payment verification data.');
        }

        $signaturePayload = implode('|', [$paymentLinkId, $referenceId, $paymentStatus, $paymentId]);
        $expectedSignature = hash_hmac('sha256', $signaturePayload, $secret);
        if (!hash_equals($expectedSignature, $signature)) {
            abort(403, 'Payment signature verification failed.');
        }

        $order = Order::where('balance_payment_link_id', $paymentLinkId)
            ->where('order_number', $referenceId)
            ->firstOrFail();

        if ($paymentStatus === 'paid') {
            $this->markBalancePaymentAsPaid($order->id, $paymentId);
            return redirect()->route('user.dashboard')->with('success', 'The remaining order balance has been paid.');
        }

        return redirect()->route('user.dashboard')->with('error', 'The balance payment was not completed.');
    }

    public function balancePaymentWebhook(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret');
        if (!$webhookSecret) {
            return response()->json(['message' => 'Razorpay webhook is not configured.'], 503);
        }

        $signature = (string) $request->header('X-Razorpay-Signature', '');
        $expectedSignature = hash_hmac('sha256', $request->getContent(), $webhookSecret);
        if (!$signature || !hash_equals($expectedSignature, $signature)) {
            return response()->json(['message' => 'Invalid webhook signature.'], 401);
        }

        if ($request->input('event') !== 'payment_link.paid') {
            return response()->json(['message' => 'Event ignored.']);
        }

        $paymentLink = $request->input('payload.payment_link.entity', []);
        $payment = $request->input('payload.payment.entity', []);
        $linkId = $paymentLink['id'] ?? null;
        $referenceId = $paymentLink['reference_id'] ?? null;
        $paymentId = $payment['id'] ?? null;

        if (!$linkId || !$referenceId || !$paymentId || ($paymentLink['status'] ?? null) !== 'paid') {
            return response()->json(['message' => 'Incomplete paid-link event.'], 422);
        }

        $order = Order::where('balance_payment_link_id', $linkId)
            ->where('order_number', $referenceId)
            ->firstOrFail();
        if ((float) $order->pending_amount <= 0
            && $order->balance_payment_payment_id === $paymentId) {
            return response()->json(['message' => 'Balance payment already recorded.']);
        }
        $expectedAmount = (int) round((float) $order->pending_amount * 100);
        if ((int) ($paymentLink['amount'] ?? 0) !== $expectedAmount
            || (int) ($paymentLink['amount_paid'] ?? 0) < $expectedAmount) {
            return response()->json(['message' => 'Payment amount does not match the outstanding balance.'], 422);
        }

        $this->markBalancePaymentAsPaid($order->id, $paymentId);
        return response()->json(['message' => 'Balance payment recorded.']);
    }

    private function razorpayApiSecret(): ?string
    {
        $mode = config('services.razorpay.mode', 'live');
        return config("services.razorpay.{$mode}_secret");
    }

    private function markBalancePaymentAsPaid($orderId, $paymentId): void
    {
        DB::transaction(function () use ($orderId, $paymentId) {
            $order = Order::whereKey($orderId)->lockForUpdate()->firstOrFail();
            if ((float) $order->pending_amount <= 0) {
                return;
            }

            $order->pending_amount = 0;
            $order->balance_payment_payment_id = $paymentId;
            $order->payment_status = 'paid';
            $order->save();
        });
    }


    public function submitCancelOrder(Request $request)
    {
        $request->validate([
            'cancel_reason'   => 'required',
            'reason_details'  => 'required|string',
            'other_reason'    => 'required_if:cancel_reason,Other|string|nullable',
            'order_number'    => 'required|exists:orders,order_number',
        ]);

        $user_id = Auth::guard('customer')->user()->id;
        $order = Order::where("order_number", $request->order_number)->first();
        $orderitem = OrderItem::where("id", $request->order_item_id)->first();


        $reason = $request->cancel_reason === 'Other' ? $request->other_reason : $request->cancel_reason;

        try {
            DB::beginTransaction();

            // Create order cancellation record
            OrderCancellation::create([
                'order_id' => $order->id,
                'user_id'  => $user_id,
                'reason'   => $reason,
                'details'  => $request->reason_details,
                'order_item_id' => $request->order_item_id,
            ]);

            // Create order status history record
            $orderStatus = new OrderStatusHistory;
            $orderStatus->user_id = $user_id;
            $orderStatus->order_id     = $order->id;
            $orderStatus->order_status_id = 11; // 'cancelled' status ID
            $orderStatus->save();

            $order->status = 11;
            $order->save();
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Order cancellation submitted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }

    public function submitRefundRequest(Request $request)
    {

        $request->validate([
            'refund_reason' => 'required|string',
            'account_number' => 'required_if:refund_mode,account|nullable',
            'confirm_account_number' => 'required_with:account_number|same:account_number|nullable',
            'ifsc_code' => 'required_if:refund_mode,account|nullable',
            'account_type' => 'required_if:refund_mode,account|nullable|in:Saving,Current',
            'bank_name' => 'required_if:refund_mode,account|nullable',
        ]);
        $user_id    = Auth::guard('customer')->user()->id;
        $order      = Order::where("order_number", $request->order_number)->first();
        $orderitem = OrderItem::where("id", $request->order_item_id)->first();
        RefundRequest::create([
            'user_id'           => $user_id,
            "order_id"          => $order->id,
            'order_item_id'     => $orderitem->id,
            'refund_reason'     => $request->refund_reason,
            'refund_details'    => $request->refund_details,
            'account_number'    => $request->account_number,
            'ifsc_code'         => $request->ifsc_code,
            'account_type'      => $request->account_type,
            'bank_name'         => $request->bank_name,
            'refund_mode' => $request->refund_type,
        ]);
        // Create order status history record
        $status = getOrderStatuss(0, 'return-requested');
        $orderStatus = new OrderStatusHistory;
        $orderStatus->user_id           = $user_id;
        $orderStatus->order_id          = $order->id;
        $orderStatus->order_item_id     = $orderitem->id;
        $orderStatus->order_status_id   = 8;
        $orderStatus->order_status   = 'return-requested';
        $orderStatus->save();

        $orderitem->status   = 'return-requested';
        $orderitem->order_status_id   = 8;
        $orderitem->save();
        return response()->json(['message' => 'Refund request submitted successfully.']);
    }

    public function orderSuccess(Request $request, $orderNumber)
    {
        $order = Order::where('id', decrypt($orderNumber))->firstOrFail();
        $walletamount = WalletHistory::where('transaction_id', $order->order_number)->first();
        return view('front.modules.dashboard.order-success', compact('order', 'walletamount'));
    }


    public function generateNewInvoice(Request $request)
    {
        $order = Order::where('orders.id', $request->id)->leftJoin('users', 'users.id', 'orders.user_id')->select('orders.*', 'users.name as user_name', 'users.email as user_email')->first();
        $checkout_data = OrderItem::with(['product', 'itemTax'])->where('order_id', $request->id)->get();
        $GSTIN = config('Site.GSTIN');
        $currency = Currency::where('currency_code', $order->currency_code)->value('symbol');
        $supplySetting = InvoiceSetting::with(['country', 'state', 'city'])
            ->where('is_active', 1)
            ->first();
        $image = 'https://vasvi.in/uploads/settings/AUG2025/1755156000-settings.png';


        $randonNum = rand(1000, 9999);
        $pdf = PDF::loadView('invoices.order_new_invoice', ['checkout_data' => $checkout_data, 'order' => $order, 'currency' => $currency, 'GSTIN' => $GSTIN, 'supplySetting' => $supplySetting, 'image' => $image]);
        // $path = Config('constant.ORDER_INVOICE_ROOT_PATH') . $request->id . $randonNum . "_invoice.pdf";
        // $invoiceDirectory = Config('constant.ORDER_INVOICE_ROOT_PATH');
        // if (!file_exists($invoiceDirectory)) {
        //     mkdir($invoiceDirectory, 0755, true);
        // }
        // $html = $pdf->getDomPDF()->outputHtml();
        // prx($html);
        $filename = $request->id . "_invoice.pdf";
        return $pdf->stream($filename);
    }

    public function generateItemsInvoice(Request $request)
    {

        $order = Order::where('orders.id', $request->id)->leftJoin('users', 'users.id', 'orders.user_id')->select('orders.*', 'users.name as user_name', 'users.email as user_email')->first();
        $checkout_data = OrderItem::with(['product', 'itemTax'])->whereIn('id', $request->ids)->get();
        $GSTIN = config('Site.GSTIN');
        $currency = Currency::where('currency_code', $order->currency_code)->value('symbol');
        $supplySetting = InvoiceSetting::with(['country', 'state', 'city'])
            ->where('is_active', 1)
            ->first();

        $randonNum = rand(1000, 9999);
        $pdf = PDF::loadView('invoices.order_new_invoice', ['checkout_data' => $checkout_data, 'order' => $order, 'currency' => $currency, 'GSTIN' => $GSTIN, 'supplySetting' => $supplySetting]);
        //$path = Config('constant.ORDER_INVOICE_ROOT_PATH') . $request->id . $randonNum . "_invoice.pdf";
        //$invoiceDirectory = Config('constant.ORDER_INVOICE_ROOT_PATH');
        //if (!file_exists($invoiceDirectory)) {
        //   mkdir($invoiceDirectory, 0755, true);
        //}
        //$filename = $request->id . "_invoice.pdf";
        //return $pdf->stream($filename);

        $pdfContent = $pdf->download()->getOriginalContent();
        return response()->json([
            'file' => base64_encode($pdfContent),
            'filename' => $request->id . "_invoice.pdf"
        ]);
    }

    public function sequelTrackOrder(Request $request)
    {
        $orderTrackResult = array();
        if($request->isMethod('post') && !empty($request->trackingNumber)){
            $orderTrackResult = SequelShippingHelper::trackSequelShipment($request->trackingNumber);
        }
        return view('front.modules.dashboard.order-sequel-track', compact('orderTrackResult'));
    }
    



}
