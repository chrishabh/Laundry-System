<?php

namespace App\Services;

use App\Enums\Constants;
use App\Models\OtpVerifications;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;


class OTPVerificationServices{

    public static function sendOtpService($request)
    {
        $sid    = env("SID");
        $token  = env("TWILIO_AUTH");
        $twilio = new Client($sid, $token);

        $phone_number = preg_replace("/[^0-9]/", "", $request['phone_number']);
        $phone_number = ((strlen($phone_number) == 10))? "+91".$phone_number : $phone_number;
    
        if(!env("SMS_LIVE")){
            $otp = mt_rand(100000,999999);
            $message = Constants::OTP_MESSAGE.$otp;
            $message = $twilio->messages
            ->create($phone_number,
              array(
                "from" => "+15089785046",
                "body" => $message
              )
            );

            OtpVerifications::insertOtpRequest([
                'user_id' => Auth::user()->id,
                'type_of_verification' => "LOGIN_VERIFICATION",
                "meta_data" => $phone_number,
                "otp_code" => $otp,
                'verification_status' => "UN-VERIFIED",
                'source' =>  $message->sid
            ]);
        }
        if(env("SMS_LIVE")){
            $otp = 123456;

            OtpVerifications::insertOtpRequest([
                'user_id' => Auth::user()->id,
                'type_of_verification' => "LOGIN_VERIFICATION",
                "meta_data" => $phone_number,
                "otp_code" => $otp,
                'verification_status' => "UN-VERIFIED",
                'source' => "Hard-coded"
            ]);
        }

        return;
       
    }

    public static function verifyOtpRequest($request)
    {

    }

}