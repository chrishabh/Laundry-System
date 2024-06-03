<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserAddress extends Model
{
    use HasFactory;

    public static function getUserAddress()
    {
        $data = UserAddress::whereNull('deleted_at')->where('user_id',Auth::User()->id)->get();

        if(count($data)>0)
        {
            return $data->toArray();
        }

        return [];
    }

    public static function insertAddress($data)
    {
        UserAddress::insert($data);
    }

    public static function updateAddress($id,$data = [])
    {
        UserAddress::whereNull('deleted_at')->update($data)
    }
}
