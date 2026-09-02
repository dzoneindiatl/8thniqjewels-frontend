<?php

namespace App\Http\Controllers\Front;

use Exception;
use Illuminate\Http\Request;
// use App\Models\ProductVariantValue;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Crypt;
use App\Models\{UserAddress, Variant};
use Illuminate\Support\Facades\Cookie;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PhonepayController extends Controller
{
    
    public function phonepayPayment(Request $request){
        try {
            // Uinversal detail for testing
            // $merchantId = 'PGTESTPAYUAT'; 
            $apiKey = '96434309-7796-489d-8924-ab56988a6076';

            $merchantId = 'M1YY3EDO2LSS';  // id 0f 8thiniqjewells
            // $merchantId = 'M1YY3EDO2LSS_26032910265';  // id 0f 8thiniqjewells
            // $apiKey = 'NWFmNDcwMDItOTZmYy00YjhlLWIwMWItNDZiMzRlZWI3NjE5';

            $redirectUrl = 'https://8thniqjewells.com/';
            $callbackUrl = 'https://8thniqjewells.com/';
            $mobileNumber = '9999999999';
            $apiUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
            $amount = 100;  // Convert to paise (₹1 = 100 paise)


            $transactionId = 'TXN' . time(); // Unique ID for every transaction
            $payload = [
                'merchantId' => 'PGTESTPAYUAT86',
                'merchantTransactionId' => $transactionId,
                'merchantUserId' => 'MUID' . rand(1111, 9999),
                'amount' => $amount, 
                'redirectUrl' => $redirectUrl,
                'redirectMode' => 'POST',
                'callbackUrl' => $callbackUrl,
                'mobileNumber' => $mobileNumber,
                'paymentInstrument' => [
                    'type' => 'PAY_PAGE'
                ]
            ];

            $base64Payload = base64_encode(json_encode($payload));
            $stringToHash = $base64Payload . "/pg/v1/pay" . $apiKey;
            $sha256 = hash('sha256', $stringToHash);
            $xVerify = $sha256 . '###' . '1';

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode(['request' => $base64Payload]),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-VERIFY: $xVerify",
                    "accept: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            echo "<pre> response : "; print_r($response); echo "</pre>";
            echo "<pre> err : "; print_r($err); echo "</pre>";
            die;

            if ($err) {
                return response()->json([
                    'success' => false,
                    'message' => $err,
                 ]);
            } else {
                $resData = json_decode($response, true);
                if (isset($resData['success']) && $resData['success'] == 1) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Payment sucessfully done',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Payment Initiation Failed: " . $resData['message'],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
        
    }

    public function phonepayPaymentStatus(Request $request){
        try {
            $transactionId = $_GET['tid']; // Get from your success.php logic
            $urlPath = "/pg/v1/status/$merchantId/$transactionId";

            // Generate Checksum for Status API: SHA256(path + saltKey) + "###" + saltIndex
            $hashString = $urlPath . $apiKey;
            $sha256 = hash("sha256", $hashString);
            $xVerify = $sha256 . '###' . $saltIndex;

            $statusUrl = "https://phonepe.com" . $urlPath;

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $statusUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-VERIFY: $xVerify",
                    "X-MERCHANT-ID: $merchantId"
                ],
            ]);

            $response = curl_exec($curl);
            $statusData = json_decode($response, true);
            curl_close($curl);

            if ($statusData['code'] === 'PAYMENT_SUCCESS') {
                echo "Payment Successful!";
            } else {
                echo "Payment Status: " . $statusData['code'];
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    
}
