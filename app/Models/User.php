<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'user_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function register_user($input)
    {
        $id = DB::table('users')->insertGetId($input);
        return $id;
    }

    public static function getUserByPhone($phone_number)
    {
        return User::whereNull('deleted_at')->where('phone_number', $phone_number)->first();
    }

    public static function getUserById($user_id)
    {
        return User::whereNull('deleted_at')->where('id', $user_id)->first();
    }

    public static function getProfileById($user_id)
    {
        return User::select( 'users.id', 'users.first_name', 'users.last_name','users.phone_number','user_photos.photo_name','user_photos.path')->leftjoin('user_photos', 'user_photos.user_id', '=', 'users.id')->whereNull('users.deleted_at')->whereNull('user_photos.deleted_at')->where('users.id', $user_id)->first();
    }

    public static function getUserList()
    {
        $return = User::whereNull('deleted_at')->get();

        if(count($return)>0){
            return $return->toArray();
        }

        return [];
    }

    public static function deleteUser($id)
    {
        User::where('id',$id)->delete();
    }

    public static function updateUserRole($id,$role)
    {
        User::whereNull('deleted_at')->where('id',$id)->update(['user_role' =>$role]);
    }


    public static function updatePassword($id,$data)
    {
        User::whereNull('deleted_at')->where('id',$id)->update($data);
    }
    
    public static function getUserListForLinking($request)
    {
        $noOfRecord = $request['no_of_records'] ?? 10;
        $current_page = $request['page_no'] ?? 1;
        $offset = ($current_page*$noOfRecord)-$noOfRecord;

        $return = User::select( DB::raw("CONCAT(COALESCE(first_name,''),' ' ,COALESCE(last_name,'')) as user_name"),'email','user_role','id')->whereNull('deleted_at')->offset($offset)->limit($noOfRecord)->get();

        if(count($return)>0){
            return $return->toArray();
        }

        return [];
    }

    public static function getUserCount()
    {
        return User::whereNull('deleted_at')->count('id');

    }
}
