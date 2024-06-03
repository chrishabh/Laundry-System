<?php

namespace App\Services;

use App\Enums\Constants;
use App\Exceptions\AppException;
use App\Models\OtpVerifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;


class OTPVerificationServices{

    public static function sendOtpService($request,$user=null)
    {
        $sid    = env("SID");
        $token  = env("TWILIO_AUTH");
        $twilio = new Client($sid, $token);

        $phone_number = preg_replace("/[^0-9]/", "", $request['phone_number']);
        $phone_number = ((strlen($phone_number) == 10))? "+91".$phone_number : $phone_number;
    
        // $timeout = env('RESEND_EXPIRY_TIME');
        // $lastOtp = OtpVerifications::orderBy('created_at', 'desc')->where('user_id',$user->id)->first();
        // if($lastOtp != null && Carbon::now()->diffInSeconds($lastOtp->created_at) < $timeout){
        //     throw new AppException('Please try after '.$timeout.' seconds');
        // }
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
                'user_id' => $user->id??null,
                'type_of_verification' => Constants::LOGIN_PHONE_VERIFICATION,
                "meta_data" => $request['phone_number'],
                "otp_code" => $otp,
                'verification_status' => Constants::UN_VERIFIED,
                'source' =>  Constants::PHONE_2FA_VERIFICATION,
                'message_id' => $message->sid
            ]);
        }
        if(env("SMS_LIVE")){
            $otp = 123456;

            OtpVerifications::insertOtpRequest([
                'user_id' => $user->id??null,
                'type_of_verification' => Constants::LOGIN_PHONE_VERIFICATION,
                "meta_data" => $request['phone_number'],
                "otp_code" => $otp,
                'verification_status' => Constants::UN_VERIFIED,
                'source' => Constants::PHONE_2FA_VERIFICATION,
            ]);
        }

        return;
       
    }

    public static function verifyOtpRequest($request)
    {
        $otp_details = OtpVerifications::getOtpCode($request['phone_number'],Constants::LOGIN_PHONE_VERIFICATION,Constants::PHONE_2FA_VERIFICATION);

        if (!$otp_details){
            throw new AppException("Invalid Verification!");
        }
        if (Carbon::parse($otp_details->created_at)->addMinutes(env('TIME_OUT_PHONE_OTP'))->isPast()) {
            OtpVerifications::deleteOtpCode($request['phone_number'],Constants::LOGIN_PHONE_VERIFICATION,Constants::PHONE_2FA_VERIFICATION);
            throw new AppException("The OTP code has expired!");
        }
        if ($otp_details->otp_code == $request['otp_code'] && $otp_details->source == Constants::PHONE_2FA_VERIFICATION) {
            $verification['verification_status'] = Constants::VERIFIED;
            OtpVerifications::updateOtpStatus($request['phone_number'],Constants::LOGIN_PHONE_VERIFICATION,Constants::PHONE_2FA_VERIFICATION,$verification);
            return true;
        } else {
            throw new AppException("Invalid OTP (One-Time Password).");
        }

        return false;
        
    }

}