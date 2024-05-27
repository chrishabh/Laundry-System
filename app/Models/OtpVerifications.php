<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerifications extends Model
{
    use HasFactory;

    public static function insertOtpRequest($data = [])
    {
        OtpVerifications::insert($data);
    }
}
