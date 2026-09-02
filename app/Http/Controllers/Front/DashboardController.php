<?php

namespace App\Http\Controllers\Front;

use Share;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Country;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Models\UserReview;
use App\Models\UserAddress;
use App\Models\BlockedReferalcode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{State, OrderStatus, WalletHistory};
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\ProductVariantCombination;
use App\Models\AffliatePaymentHistory; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect, Session, Config, DB, Response, Str;
use App\Models\ProductVariantCombinationImage;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            
        if (Auth::guard('customer')->check()) {
            $user = User::where('id', Auth::guard('customer')->user()->id)->first();
            $redeemedamount = WalletHistory::where('user_id', $user->id)->where('type', 'debit')->sum('amount');
            $totalrefund = WalletHistory::where('user_id', $user->id)
                ->where('type', 'credit')
                ->where('description', 'like', '%refund%')
                ->sum('amount');
            $userAddressDetails = UserAddress::where('user_id', Auth::guard('customer')->user()->id)->get();
            $countries = Country::where('is_active', 1)->pluck('name', 'id');
            $states = State::where('country_id', 101)->where('is_active', 1)->pluck('name', 'id');
            $allStatuses = OrderStatus::orderBy('step')->where('active', 1)->pluck('name', 'id');
            $referralLink = url('?referral=' . Auth::guard('customer')->user()->user_referral_code);
            $referralCode = Auth::guard('customer')->user()->user_referral_code;

            $orderCurentDetails = array();
            $orderDelivedDetails = array();
            $orderCancelledDetails = array();
            if(auth()->guard('customer')->user()->user_role_id==4){
                // $orderDetails = Order::with('items', 'items.productGraphics')->where('user_id', Auth::guard('customer')->user()->id)->orderBy('id', 'desc')->get();
                $orderCurentDetails = Order::with('items', 'items.productGraphics')->where('user_id', Auth::guard('customer')->user()->id)->whereNotIn('status',array('delivered','cancelled','cancelled_by_customer','return-rejected'))->orderBy('id', 'desc')->get();
                $orderDelivedDetails = Order::with('items', 'items.productGraphics')->where('user_id', Auth::guard('customer')->user()->id)
                ->whereIn('status',array('delivered'))->orderBy('id', 'desc')->get();
                $orderCancelledDetails = Order::with('items', 'items.productGraphics')->where('user_id', Auth::guard('customer')->user()->id)
                ->whereIn('status',array('cancelled','cancelled_by_customer','return-rejected'))->orderBy('id', 'desc')->get();
            }
            
            $referalOrderCurentDetails = array();
            $referalOrderDelivedDetails = array();
            $referalOrderCancelledDetails = array();
            $referalCustomerList = array();
            $paymentDetails = array();
            $referalMaxPercentage = 0;
            if(auth()->guard('customer')->user()->user_role_id==5){
                // For Affliate User orders 
                if($referralCode){
                    $referalOrderCurentDetails = Order::with('items', 'items.productGraphics')
                    ->where('referal_user_id', Auth::guard('customer')->user()->id)
                    ->where('is_referal',1)
                    ->whereNotIn('status',array('delivered','cancelled','cancelled_by_customer','return-rejected'))->orderBy('id', 'desc')->get();
                    
                    $referalOrderDelivedDetails = Order::with('items', 'items.productGraphics')
                    ->where('referal_user_id', Auth::guard('customer')->user()->id)
                    ->where('is_referal',1)
                    ->whereIn('status',array('delivered'))->orderBy('id', 'desc')->get();

                    $referalOrderCancelledDetails = Order::with('items', 'items.productGraphics')
                    ->where('referal_user_id', Auth::guard('customer')->user()->id)
                    ->where('is_referal',1)
                    ->whereIn('status',array('cancelled','cancelled_by_customer','return-rejected'))->orderBy('id', 'desc')->get();

                    $referalCustomerList = Order::where('referal_user_id', Auth::guard('customer')->user()->id)
                    ->where('is_referal', 1)
                    ->select('user_id', 'coupon_name')
                    ->get()
                    ->groupBy('user_id')
                    ->map(function ($group) {
                        return [
                            'total_count' => $group->count(),
                            'coupon_name' => $group->pluck('coupon_name')->unique()->toArray() // This gives you the IDs
                        ];
                    });

                    $paymentDetails = AffliatePaymentHistory::where('affiliate_id', Auth::guard('customer')->user()->id)
                    ->orderBy('id', 'desc')->get();

                    $referalMaxPercentage = auth()->guard('customer')->user()->referal_max_percentage;
                }
                 // For Affliate User orders 
            }
            
            $shareTitle = 'Join me on 8thnique! Use my referral link.';

            $wishlistData = Wishlist::where('user_id', auth()->guard('customer')->user()->id)->limit(10)->get();

            $share_buttons = \Jorenvh\Share\ShareFacade::page($referralLink, $shareTitle)
                ->facebook()
                ->twitter()
                ->linkedin()
                ->whatsapp()
                ->telegram()
                ->reddit();

            return view('front.modules.dashboard.index', compact('user', 'userAddressDetails', 'countries', 'states','orderCurentDetails','orderDelivedDetails','orderCancelledDetails', 'share_buttons', 'allStatuses', 'redeemedamount', 'totalrefund','wishlistData','referalOrderCurentDetails','referalOrderDelivedDetails','referalOrderCancelledDetails','referalCustomerList','paymentDetails','referalMaxPercentage'));
        } else {
            return redirect()->route('home.index');
        }
        } catch (Exception $e) {
            // @dd($e->getMessage());
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }


    public function userDashboard(Request $request)
    {
        try {
            $user = User::where('id', Auth::guard('customer')->user()->id)->first();
            $userAddressDetails = UserAddress::where('user_id', Auth::guard('customer')->user()->id)->get();
            $countries = Country::where('is_active', 1)->pluck('name', 'id');
            $states = State::where('country_id', 101)->where('is_active', 1)->pluck('name', 'id');
            $orderDetails = Order::with('items', 'items.productGraphics')->where('user_id', Auth::guard('customer')->user()->id)->orderBy('id', 'desc')->get();
            $allStatuses = OrderStatus::orderBy('step')->where('active', 1)->get();
            $share_buttons = \Share::page(
                'https://www.laravelclick.com/post/laravel-10-social-media-share-buttons-integration-tutorial',
                'How to Add Social Media Share Button in Laravel 10 App?'
            )->facebook()->twitter()->linkedin()->whatsapp()->telegram()->reddit();

            return view('front.modules.dashboard.index', compact('user', 'userAddressDetails', 'countries', 'states', 'orderDetails', 'share_buttons', 'allStatuses'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }
    public function addresses(Request $request)
    {
        try {
            $userAddresses = UserAddress::where('user_id', Auth::guard('customer')->user()->id)->get();

            return view('front.modules.dashboard.addresses', compact('userAddresses'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }
    public function orders(Request $request)
    {
        // try {
        $active_orders = OrderItem::whereNotIn('status', ['delivered', 'cancelled', 'returned'])
            ->leftjoin('orders', 'orders.id', 'order_items.order_id')
            ->leftjoin('product_variant_combinations', 'product_variant_combinations.id', 'order_items.product_id')
            ->leftjoin('products', 'product_variant_combinations.product_id', 'products.id')
            ->leftjoin('user_addresses', 'user_addresses.id', 'orders.address_id')
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->select('order_items.*', 'orders.order_number', 'orders.currency_code', 'products.name', 'user_addresses.name', 'user_addresses.email', 'user_addresses.phone_number', 'user_addresses.country', 'user_addresses.address_line_1', 'user_addresses.address_line_2', 'user_addresses.postal_code', 'user_addresses.city', 'user_addresses.state', 'user_addresses.landmark')
            ->get();
        $active_orders_count = $active_orders->count();
        $active_orders = $active_orders->toArray();

        if (!empty($active_orders)) {
            foreach ($active_orders as &$active_order) {
                $active_order['product_image'] = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $active_order['product_id'])->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->select('product_images.image')->first();
                if (!empty($active_order['product_image'])) {
                    $productImage = (!empty($active_order['product_image'])) ? Config('constant.PRODUCT_IMAGE_URL') . $active_order['product_image']['image'] : Config('constant.IMAGE_URL') . "noimage.png";
                    $active_order['product_image'] = $productImage;
                }
            }
        }

        $delivered_orders = OrderItem::where('status', 'delivered')
            ->leftjoin('orders', 'orders.id', 'order_items.order_id')
            ->leftjoin('product_variant_combinations', 'product_variant_combinations.id', 'order_items.product_id')
            ->leftjoin('products', 'product_variant_combinations.product_id', 'products.id')
            ->leftjoin('user_addresses', 'user_addresses.id', 'orders.address_id')
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->select('order_items.*', 'orders.order_number', 'orders.currency_code', 'products.name', 'user_addresses.name', 'user_addresses.email', 'user_addresses.phone_number', 'user_addresses.country', 'user_addresses.address_line_1', 'user_addresses.address_line_2', 'user_addresses.postal_code', 'user_addresses.city', 'user_addresses.state', 'user_addresses.landmark')
            ->get();
        $delivered_orders_count = $delivered_orders->count();
        $delivered_orders = $delivered_orders->toArray();

        if (!empty($delivered_orders)) {
            foreach ($delivered_orders as &$delivered_order) {
                $delivered_order['product_image'] = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $delivered_order['product_id'])->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->select('product_images.image')->first();
                if (!empty($delivered_order['product_image'])) {
                    $productImage = (!empty($delivered_order['product_image'])) ? Config('constant.PRODUCT_IMAGE_URL') . $delivered_order['product_image']['image'] : Config('constant.IMAGE_URL') . "noimage.png";
                    $delivered_order['product_image'] = $productImage;
                }
            }
        }

        $cancelled_orders = OrderItem::where('status', 'cancelled')
            ->leftjoin('orders', 'orders.id', 'order_items.order_id')
            ->leftjoin('product_variant_combinations', 'product_variant_combinations.id', 'order_items.product_id')
            ->leftjoin('products', 'product_variant_combinations.product_id', 'products.id')
            ->leftjoin('user_addresses', 'user_addresses.id', 'orders.address_id')
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->select('order_items.*', 'orders.order_number', 'orders.currency_code', 'products.name', 'user_addresses.name', 'user_addresses.email', 'user_addresses.phone_number', 'user_addresses.country', 'user_addresses.address_line_1', 'user_addresses.address_line_2', 'user_addresses.postal_code', 'user_addresses.city', 'user_addresses.state', 'user_addresses.landmark')
            ->get();
        $cancelled_orders_count = $cancelled_orders->count();
        $cancelled_orders = $cancelled_orders->toArray();

        if (!empty($cancelled_orders)) {
            foreach ($cancelled_orders as &$cancelled_order) {
                $cancelled_order['product_image'] = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $cancelled_order['product_id'])->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->select('product_images.image')->first();
                if (!empty($cancelled_order['product_image'])) {
                    $productImage = (!empty($cancelled_order['product_image'])) ? Config('constant.PRODUCT_IMAGE_URL') . $cancelled_order['product_image']['image'] : Config('constant.IMAGE_URL') . "noimage.png";
                    $cancelled_order['product_image'] = $productImage;
                }
            }
        }
        // echo "<pre>"; print_r($active_orders); die;
        return view('front.modules.dashboard.orders', compact('active_orders', 'delivered_orders', 'cancelled_orders', 'cancelled_orders_count', 'active_orders_count', 'delivered_orders_count'));
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        // }
    }



    /*public function wishlist()
    {
        try {
         $wishlistData = Wishlist::where('user_id', auth()->guard('customer')->user()->id)
            ->get();

            $html = view('front.modules.dashboard.wishlist', compact('wishlistData'))->render();
            return response()->json([
                'status' => true,
                'wishlistData' => $html
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }*/
    public function wishlist(Request $request)
    {
        try {
            if ($request->ajax()) {
                $count = Wishlist::where('user_id', auth()->guard('customer')->user()->id)->count();
                $wishlistData = Wishlist::where('user_id', auth()->guard('customer')->user()->id)
                    ->get();
                $html = view('front.modules.dashboard.wishlist', compact('wishlistData'))->render();
                return response()->json([
                    'status' => true,
                    'wishlistData' => $html,
                    'data' => $count
                ]);
            } else {
                $wishlistData = Wishlist::where('user_id', auth()->guard('customer')->user()->id)
                    ->get();
                $html = view('front.modules.dashboard.wishlist', compact('wishlistData'))->render();
                return response()->json([
                    'status' => true,
                    'wishlistData' => $html
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function updateProfile(Request $request)
    {
        $formData = $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),

                array(
                    'image'      => 'nullable|mimes:jpg,jpeg,png,webp',
                    'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->guard('customer')->user()->id)->where('user_role_id', config('constant.ROLE_ID.CUSTOMER_ROLE_ID'))],
                    'phone_number' =>  ['required', 'numeric', Rule::unique('users')->ignore(auth()->guard('customer')->user()->id)->where('user_role_id', config('constant.ROLE_ID.CUSTOMER_ROLE_ID')), 'digits:10'],

                ),
                array(

                    "image.mimes" => trans("The image field must be a file of type jpg jpeg png"),
                    "phone_number.required" => trans("The phone number field is required"),

                )
            );
            if ($validator->fails()) {
                //$response = $this->change_error_msg_layout($validator->errors()->getMessages());
               // return Response::json($response, 200);

                return Redirect::route('user.dashboard')->withErrors($validator);
                
            } else {
                DB::beginTransaction();
                $obj   = User::find(Auth::guard('customer')->user()->id);
                $obj->name = $request->name;
                $obj->phone_number = $request->phone_number;
                $obj->gender = $request->gender;
                $obj->date_of_birth = $request->date_of_birth;

                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $originalName = $request->file('image')->getClientOriginalName();
                    $fileName = time() . '-image.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constant.USER_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('image')->move($folderPath, $fileName)) {
                        $obj->image = $folderName . $fileName;
                    }
                }
                $obj->save();
                $lastId = $obj->id;
                 DB::commit();

                // $response = array();
                // $response["status"] = "success";
                // $response["message"] = trans("Profile Updated Successfully");
                // $response["redirect_url"] = url('/dashboard');
                // $response["data"] = (object) array();
                // $response["http_code"] = 200;
                // return Response::json($response, 200);

                return Redirect::route('user.dashboard')->with('success', 'Profile Updated Successfully');
            }
        } else {
            // $response = array();
            // $response["status"] = "error";
            // $response["message"] = trans("Invalid request");
            // $response["redirect_url"] = url('/dashboard');
            // $response["data"] = (object) array();
            // $response["http_code"] = 500;
            // return Response::json($response, 500);
            return Redirect::route('user.dashboard')->withErrors("Invalid request");
        }
    }

    public function changePassword(Request $request)
    {
        $user = User::where('id', auth()->guard('customer')->user()->id)->first();
        if (!empty($request->all())) {
            $formData = $request->all();
            Validator::extend('current_password_check', function ($attribute, $value, $parameters, $validator) use ($user) {
                return Hash::check($value, $user->password);
            });
            $validator = Validator::make(
                $request->all(),
                array(
                    'current_password' => (!empty($user->password)) ? 'required|current_password_check' : '',
                    'new_password' => ['required', Password::min(8)],
                    'confirm_password' => 'required|required_with:new_password|min:8|same:new_password'

                ),
                array(

                    "current_password.current_password_check" => trans("The password entered is invalid"),
                    "current_password.required" => trans("The current password field is required"),
                    "new_password.required" => trans("The new password field is required"),
                    "new_password.min" => trans("The new password must be atleast 8 characters"),
                    "confirm_password.required" => trans("The confirm password field is required"),
                    "confirm_password.same" => trans("The confirm password should be same as new password")

                )
            );
            if ($validator->fails()) {
                $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                return Response::json($response, 200);
            } else {
                DB::beginTransaction();
                $obj   = User::find(Auth::guard('customer')->user()->id);
                $obj->password = Hash::make($request->new_password);
                $obj->save();
                $lastId = $obj->id;
                if (empty($lastId)) {
                    DB::rollback();
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("Something_went_wrong");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }
                DB::commit();

                $response = array();
                $response["status"] = "success";
                $response["msg"] = trans("Password Changed Successfully");
                $response["data"] = (object) array();
                $response["http_code"] = 200;
                return Response::json($response, 200);
            }
        } else {
            return view('front.modules.dashboard.change-password');
        }
    }

    public function addAddress(Request $request)
    {
        if (!empty($request->all())) {
            $validator = Validator::make( $request->all(),
                array(
                    'address'      => 'required',
                    'name'      => 'required',
                   // 'email' => ['required', 'email'],
                    'phone_number' =>  ['required', 'numeric', 'digits:10'],
                    'country_id'      => ['required', 'numeric'],
                    'state_id'      => ['required', 'numeric'],
                    'city_id' => ['required', 'numeric'],
                    'postal_code' =>['required', 'numeric', 'digits:6'],
                    'type' => 'required',
                    'address_type' => 'required',
                )
            );
            if ($validator->fails()) {
                $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                return Response::json($response, 200);
            } else {
                DB::beginTransaction();
                if(!empty($request->address_id)){
                    $obj   = UserAddress::find($request->address_id);
                } else {
                    $obj   = new UserAddress;
                }
                $obj->user_id = Auth::guard('customer')->user()->id;
                $obj->name = !empty($request->name) ? $request->name : NULL;
                $obj->phone_number = !empty($request->phone_number) ? $request->phone_number : NULL;
                $obj->country_id = !empty($request->country_id) ? $request->country_id : NULL;
                $obj->address = !empty($request->address) ? $request->address : NULL;
                $obj->postal_code = !empty($request->postal_code) ? $request->postal_code : NULL;
                $obj->city_id = !empty($request->city_id) ? $request->city_id : NULL;
                $obj->state_id = !empty($request->state_id) ? $request->state_id : NULL;
                $obj->landmark = !empty($request->landmark) ? $request->landmark : NULL;
                $obj->type = !empty($request->type) ? $request->type : NULL;
                $obj->address_type = !empty($request->address_type) ? $request->address_type : NULL;

                $checkUserAddresses = UserAddress::where('user_id', Auth::guard('customer')->user()->id)->where('is_primary', 1)->count();
                if ($checkUserAddresses == 0) {
                    $obj->is_primary = 1;
                }
                $obj->save();

                $lastId = $obj->id;
                if (empty($lastId)) {
                    DB::rollback();
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("Something went wrong");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }
                DB::commit();

                $response = array();
                $response["status"] = "success";
                $response["msg"] = trans("Address added Successfully");
                $response["data"] = (object) array();
                $response["http_code"] = 200;
                return Response::json($response, 200);
            }
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("Invalid request");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }
    }

    public function editAddress(Request $request, $addressId)
    {
        $formData = $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'name'      => 'required',
                    'email' => ['required', 'email'],
                    'phone_number' =>  ['required', 'numeric', 'digits:10'],
                    'country'      => 'required',
                    'address_line_1'      => 'required',
                    'postal_code' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                )
            );
            if ($validator->fails()) {
                $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                return Response::json($response, 200);
            } else {
                DB::beginTransaction();
                $obj   = UserAddress::find($addressId);
                $obj->name = !empty($request->name) ? $request->name : NULL;
                $obj->email = !empty($request->email) ? $request->email : NULL;
                $obj->phone_number = !empty($request->phone_number) ? $request->phone_number : NULL;
                $obj->country = !empty($request->country) ? $request->country : NULL;
                $obj->address_line_1 = !empty($request->address_line_1) ? $request->address_line_1 : NULL;
                $obj->address_line_2 = !empty($request->address_line_2) ? $request->address_line_2 : NULL;
                $obj->postal_code = !empty($request->postal_code) ? $request->postal_code : NULL;
                $obj->city = !empty($request->city) ? $request->city : NULL;
                $obj->state = !empty($request->state) ? $request->state : NULL;
                $obj->landmark = !empty($request->landmark) ? $request->landmark : NULL;
                $obj->save();

                $lastId = $obj->id;
                if (empty($lastId)) {
                    DB::rollback();
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("Something went wrong");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }
                DB::commit();

                $response = array();
                $response["status"] = "success";
                $response["msg"] = trans("Address updated Successfully");
                $response["data"] = (object) array();
                $response["http_code"] = 200;
                return Response::json($response, 200);
            }
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("Invalid request");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }
    }

    public function deleteAddress(Request $request, $addressId)
    {
        $checkIfAddressExists = UserAddress::where('id', $addressId)->first();
        if (!empty($checkIfAddressExists)) {

            UserAddress::where('id', $addressId)->delete();
            if ($checkIfAddressExists->is_primary == 1) {
                $addressCount = UserAddress::where('user_id', $checkIfAddressExists->user_id)->count();
                if ($addressCount > 0) {
                     UserAddress::where('user_id', $checkIfAddressExists->user_id)->first()->update(['is_primary' => 1]);
                }
            }
            $response = array();
            $response["status"] = true;
            $response["msg"] = trans("Address deleted Successfully");
            return Response::json($response, 200);
        } else {
            $response = array();
            $response["status"] = false;
            $response["msg"] = trans("invalid request");
            return Response::json($response, 200);
        }
    }

    public function makeAddressPrimary(Request $request, $addressId)
    {
        $checkIfAddressExists = UserAddress::where('id', $addressId)->first();
        if (!empty($checkIfAddressExists)) {

            UserAddress::where('user_id', $checkIfAddressExists->user_id)->update(['is_primary' => 0]);
            UserAddress::where('id', $addressId)->update(['is_primary' => 1]);

            $response = array();
            $response["status"] = true;
            $response["msg"] = trans("Address made primary successfully");
            return Response::json($response, 200);
        } else {
             $response = array();
            $response["status"] = false;
            $response["msg"] = trans("invalid request");
            return Response::json($response, 200);
        }
    }
    public function addReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|max:255',
            'review' => 'required|max:5000',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        $user = Auth::guard('customer')->user();

        $uploadedImages = [];

        if ($request->hasFile('image')) {

            $uploadedImages = [];

            foreach ($request->file('image') as $image) {
                $extension = $image->getClientOriginalExtension();
                $originalName = $image->getClientOriginalName();
                $fileName = time() . '-' . uniqid() . '.' . $extension;

                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constant.REVIEW_IMAGE_ROOT_PATH') . $folderName;

                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true);
                }

                if ($image->move($folderPath, $fileName)) {
                    $uploadedImages[] = $folderName . $fileName;
                }
            }
        }
        UserReview::create([
            'product_id' => $request->product_id,
            'user_id' => $user->id, // optional
            'title' => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
            'image' => json_encode($uploadedImages),
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }



    public function toggle(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $productId = $request->product_id;
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            //return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
            $wishlistCount = $user ? Wishlist::where('user_id', $user->id)->count() : 0;
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist', 'wishlistCount' => $wishlistCount]);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            //return response()->json(['status' => 'added','message' => 'Added to wishlist']);
            $wishlistCount = $user ? Wishlist::where('user_id', $user->id)->count() : 0;
            return response()->json(['status' => 'added', 'message' => 'Added to wishlist', 'wishlistCount' => $wishlistCount]);
        }
    }

    public function getAddresseById(Request $request,$addressId)
    {
        try {
            $userAddresses = UserAddress::where('user_id', Auth::guard('customer')->user()->id)->where('id', $addressId)->get();
            if(!empty($userAddresses)){
                return $userAddresses;
            } else {
                return 'NULL';
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function blockReferalCode(Request $request, $affiliate_id,$customer_id,$referal_code,$status)
    {
        if($affiliate_id=='' || $customer_id=='' || $referal_code==''){
            return response()->json(['status' => false, 'message' => 'Parameter is not valid']);
        }
        if($status=='add'){
            $BlockedReferalcode = new BlockedReferalcode;
            $BlockedReferalcode->affiliate_id = $affiliate_id ?? '';
            $BlockedReferalcode->customer_id    = $customer_id     ?? '';
            $BlockedReferalcode->referal_code    = $referal_code     ?? '';
            if ($BlockedReferalcode->save()) {
                return response()->json(['status' => true, 'message' => 'Referal Code successfully blocked']);
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong: ' . $e->getMessage()]);
            }
        }

        if($status=='remove'){
            if (BlockedReferalcode::where('affiliate_id', $affiliate_id)->where('customer_id', $customer_id)->where('referal_code', $referal_code)->delete()) {
                return response()->json(['status' => true, 'message' => 'Referal Code successfully Unblocked']);
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong: ' . $e->getMessage()]);
            }
        }
    }
}
