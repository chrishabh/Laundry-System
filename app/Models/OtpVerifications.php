<?php

namespace App\Models;

use App\Enums\Constants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OtpVerifications extends Model
{
    use HasFactory;

    public static function insertOtpRequest($data = [])
    {
        OtpVerifications::insert($data);
    }

    public static function getOtpCode($phone,$type,$source)
    {
        return  OtpVerifications::whereNull('deleted_at')->where('meta_data',$phone)->where('type_of_verification',$type)->where('source',$source)->where('verification_status', Constants::UN_VERIFIED)->orderBy('id', 'DESC')->first();
    }

    public static function deleteOtpCode($phone,$type,$source)
    {
        return  OtpVerifications::whereNull('deleted_at')->where('meta_data',$phone)->where('type_of_verification',$type)->where('source',$source)->where('verification_status', Constants::UN_VERIFIED)->update(['deleted_at' => Carbon::now()]);
    }

    public static function updateOtpStatus($phone,$type,$source,$data)
    {
        return  OtpVerifications::whereNull('deleted_at')->where('meta_data',$phone)->where('type_of_verification',$type)->where('source',$source)->where('verification_status', Constants::UN_VERIFIED)->update($data);
    }
}
