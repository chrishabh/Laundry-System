<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware'=> ['tracker']],function () {
        Route::group(['namespace' => 'Api\Auth'], function () {

            Route::post('request-otp','UserController@requestOTP');		
            Route::post('login','UserController@userLogin');		
            //Route::post('register','UserController@userSignUp');
            Route::get('user-list','UserController@getUserList');
            //Route::post('update-user','UserController@updateUser');
            //Route::post('forgot-password','UserController@forgotPassword');
        });

        Route::group(['namespace' => 'Api\Auth'], function () {
            Route::group(['middleware'=> ['auth:api']],function () {
                //Route::post('verify-otp','UserController@verifyOtp');
                Route::post('update-profile','UserController@updateProfile');
                Route::get('profile','UserController@userProfile');
                Route::post('upload-photo','UserController@uploadPhoto');
                Route::post('create-order','OrdersController@createOrder');
                Route::post('edit-order','OrdersController@editOrder');
                Route::post('order-listing','OrdersController@orderListing');
                Route::post('update-status','OrdersController@updateOrderStatus');
                Route::post('order-summary','OrdersController@orderSummary');

            });
            
        });

    });

        // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        //     return $request->user();
        // });

        // If API not found
        Route::fallback(function(){
            return response()->routeNotFound();
        });
