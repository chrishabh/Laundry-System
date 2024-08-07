<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\AppException;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Services\UserServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdationFormRequest;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\GetPayToDetailsFormRequest;
use App\Http\Requests\GetProjectDetialsFormRequest;
use App\Http\Requests\LinkUserAndFloorsFormRequest;
use App\Http\Requests\LinkUserAndProjectsFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Http\Requests\UpdateUserProfileFormRequest;
use App\Http\Requests\UpdateUserRoleFormRequest;
use App\Http\Requests\VerifyOtpServiceFormRequest;
use App\Models\LookUpValue;
use App\Services\OTPVerificationServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class UserController extends Controller
{

    public static function userSignUp(SignUpFormRequest $request)
    {
         $requestData = $request->validated();

            $user = new UserServices();
            $user->register($request);

		return  response()->data([],'Registration Success');
    }

    public static function requestOTP(VerifyOtpServiceFormRequest  $request)
    {

        $requestData = $request->validated();
        OTPVerificationServices::sendOtpService($request);
        return  response()->success();

    }

    public static function userLogin(LoginFormRequest  $request)
    {

        $requestData = $request->validated();
        $user = new UserServices();
        $data = $user->login($request);
        return  response()->data(['user'=>$data]);

    }

    public static function userProfile()
    {
        $user = new UserServices();
        $data = $user->profile();
        return  response()->data(['profile'=>$data]);
    }

    public static function updateProfile(UpdateUserProfileFormRequest  $request)
    {
        $requestData = $request->validated();
        $user = new UserServices();
        if($user->updateProfile($request)){
            return  response()->success();
        }else{
            throw new AppException("Something went wrong!");
        }
    }

    public static function addAddress(AddressUpdationFormRequest  $request)
    {
        $requestData = $request->validated();
        $user = new UserServices();
        if($user->userAddress($request,'add')){
            return  response()->success();
        }else{
            throw new AppException("Something went wrong!");
        }
    }

    public static function editAddress(AddressUpdationFormRequest  $request)
    {
        $requestData = $request->validated();
        $user = new UserServices();
        if($user->userAddress($request,'edit')){
            return  response()->success();
        }else{
            throw new AppException("Something went wrong!");
        }
    }

    public static function deleteAddress(AddressUpdationFormRequest  $request)
    {
        $requestData = $request->validated();
        $user = new UserServices();
        if($user->userAddress($request,'delete')){
            return  response()->success();
        }else{
            throw new AppException("Something went wrong!");
        }
    }

    public static function uploadPhoto(Request $request)
    {
        $user = new UserServices();
        $data = $user->uploadPhoto($request);
        return  response()->success();
    }

    public static function lookUpValue()
    {
        $data = LookUpValue::getLookUpValue();
        return  response()->data(['look_up'=>$data]);
    }

    public static function test()
    {
        UserServices::cleanServerDirectory();
    }

    public static function wagesPortalController(Request $request)
    {
        UserServices::wagesPortalController($request);
    }


    public static function getUserList()
    {
        $user = new UserServices();
        $data = $user->getUserList();
        return  response()->data(['user_list'=>$data]);
    }

    public static function dashboard()
    {
        $user = new UserServices();
        $data = $user->dashboard();
        return  response()->data($data);
    }

    public static function updateUser(UpdateUserRoleFormRequest  $request)
    {
        $user = new UserServices();
        $data = $user->updateUserRole($request);
        return  response()->success();
    }

    public static function forgotPassword(ForgotPasswordFormRequest $request)
    {
        $user = new UserServices();
        $data = $user->forgotPassword($request);
        return  response()->success();
    }

    public static function decryptPassword(ForgotPasswordFormRequest $request)
    {
        $user = new UserServices();
        $data = $user->decryptPassword($request);
        return  response()->data($data);
    }

    public static function verifyOtp(VerifyOtpServiceFormRequest $request)
    {
        $requestData = $request->validated();
        OTPVerificationServices::verifyOtpRequest($request);
        return  response()->success();
    }
}
