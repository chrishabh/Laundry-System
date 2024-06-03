<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Exceptions\AppException;
use App\Exceptions\BusinessExceptions\RegisterFailedException;
use App\Models\UserAddress;
use App\Models\UserAuthorization;
use App\Models\UserPhotos;
use App\Models\UserProjectLinking;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\File;

class UserServices{

    public function login($request){

        $user = User::getUserByPhone($request['phone_number']);

        if (!$user) {
            $input = [
               "phone_number"=>$request['phone_number'],
             
            ];
            User::register_user($input);
            if(OTPVerificationServices::verifyOtpRequest($request))
            {
                $user['token'] = $user->createToken('MyApp')->accessToken;
            }
        } else{
            if(OTPVerificationServices::verifyOtpRequest($request))
            {
                $user['token'] = $user->createToken('MyApp')->accessToken;
            }
        }


        return $user;

    }

    public function profile(){

        $user = User::getProfileById(Auth::User()->id);
        $address = UserAddress::getUserAddress();

        return [
            'user_detail' => $user,
            'address' => $address
        ];

    }

    public function uploadPhoto($request){

        $user = UserPhotos::uploadPhoto($request);

        return $user;

    }

    public function register($request){

        $input = [
            "first_name"=>$request['first_name'],
            "last_name"=>$request['last_name'],
            "phone_number"=>$request['phone_number'],
            'user_role' => $request['user_role'],
            "address_1"=>$request['address_1'],
            "address_2"=>$request['address_2']??null,
            "city"=>$request['city'],
            'pincode' => $request['pincode'],
            "state"=>$request['state'],
            "country"=>$request['country'],
            "password"=> bcrypt($request['password']),
        ];

        if(User::getUserByPhone($request['phone_number'])){
            throw new AppException("Email Address is already registerd with us. PLease login.");
        }
        else{
            // try {
                User::register_user($input);
            // }
            // catch(\Exception $e){
            //     return $e->getMessage();
            // }
        }

    }

    public static function cleanServerDirectory()
    {
        $construction_count = 0;
        $wages_count = 0;
        $storage_count = 0;
        $str = 0;
        $path = public_path('construction_data/');
        if(file_exists($path)){
            $files = scandir(public_path('construction_data/'));
            //$files =  File::allFiles($path);
            foreach($files as $value){
                if ($value != "." && $value != "..") {
                    if (file_exists($path.$value))
                    $flag = unlink($path.$value);$construction_count++;
                }
            }
            echo "Public Construction data files cleaned ".$construction_count."\n";
        }

        $path = public_path('storage/');
        if(file_exists($path)){
            $files = scandir(public_path('storage/'));
            //$files =  File::allFiles($path);
            foreach($files as $value){
                if ($value != "." && $value != "..") {
                    if (file_exists($path.$value))
                    $flag = unlink($path.$value);$storage_count++;
                }
            }
            echo "Public Storage files cleaned ".$storage_count."\n";
        }

        $path = public_path('wages_data/');
        if(file_exists($path)){
            $files = scandir(public_path('wages_data/'));
            //$files =  File::allFiles($path);
            foreach($files as $value){
                if ($value != "." && $value != "..") {
                    if (file_exists($path.$value))
                    $flag = unlink($path.$value);$wages_count++;
                }
            }
            echo "Public Wages data files cleaned ".$wages_count."\n";
        }
        
        $path = $_SERVER['DOCUMENT_ROOT']."/storage";
        
         if(file_exists($path)){
             $files = scandir($path);
             //$files =  File::allFiles($path);
             foreach($files as $value){
                 if ($value != "." && $value != "..") {
                     if (file_exists($path.$value))
                    $flag = unlink($path);$str++;
                 }
            }
            echo "Wages Portal Storage files cleaned => ".$str."\n";
        }

    }

    public static function wagesPortalController($request)
    {
        $path = $_SERVER['DOCUMENT_ROOT']."/".$request['folder'];
        
         if(file_exists($path)){
            //  $files = scandir($path);pp($files);
            //  //$files =  File::allFiles($path);
            //  foreach($files as $value){
            //      if ($value != "." && $value != "..") {
            //          if (file_exists($path.$value))
                    $flag = rmdir($path);
            //      }
            // }
            echo "Wages Portal files cleaned => ".$path."\n";
        }
    }

    public static function getUserList()
    {
        return User::getUserList();
    }

    public static function updateUserRole($request)
    {
        if($request['role_request'] == 'delete')
        {
            User::deleteUser($request['id']);
        }else{
            User::updateUserRole($request['id'],$request['role_request']);
        }
    }

    public static function forgotPassword($request)
    {
        $user = User::getUserByEmail($request['email']);

        if (!$user) {
            throw new AppException('Your Account does not exists.');
        } 

        $input = [
            "password"=>bcrypt($request['password']),
        ];

        User::updatePassword( $user['id'], $input);
    }

    public static function decryptPassword($request)
    {
        $user = User::getUserByEmail($request['email']);

        if (!$user) {
            throw new AppException('Your Account does not exists.');
        }

        $password['decrypted_password'] = decrypt($user['password']);

        return $password;
    }

    public static function updateProfile($request)
    {
        $user_data = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name']
        ];
        User::updatePassword(Auth::User()->id,$user_data);

        foreach($request['address'] as $key => &$value)
        {
            if(isset($value['id'])){

                UserAddress::updateAddress(Auth::User()->id,$value);

            }else{
                $value_data['user_id'] = Auth::User()->id;

                $value_data = $value;
                UserAddress::insertAddress($value_data);

            }
        }
        return true;
    }
}