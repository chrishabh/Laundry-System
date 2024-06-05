<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderFormRequest;
use App\Http\Requests\EditOrderFormRequest;
use App\Http\Requests\OrderListingFormRequest;
use App\Http\Requests\OrderSummaryFormRequest;
use App\Http\Requests\UpdateOrderStatusFormRequest;
use App\Models\UserOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public static function createOrder(CreateOrderFormRequest $request){

        $requestData = $request->validated();
        UserOrders::createOrder($request);
        return  response()->success();
    }

    public static function editOrder(EditOrderFormRequest $request){
        $requestData = $request->validated();
        UserOrders::editOrder($request);
        return  response()->success();
    }

    public static function orderListing(OrderListingFormRequest $request){
        $requestData = $request->validated();
        return  response()->data(['order_list'=> UserOrders::orderListing($request)]);
    }

    public static function updateOrderStatus(UpdateOrderStatusFormRequest $request){
        $requestData = $request->validated();
        UserOrders::updateOrderStatus($request);
        return  response()->success();
    }

    public static function orderSummary(OrderSummaryFormRequest $request){
        $request->validated();
        return  response()->data(['order_summary' => UserOrders::orderSummary($request)]);
    }


}
