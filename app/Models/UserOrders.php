<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserOrders extends Model
{
    use HasFactory;

    public static function createOrder($request){

        foreach($request['items'] as $value){
            $data = [
                'user_id' => Auth::User()->id,
                'pickup_date' => $request['pickup_date'],
                'delivery_date' => $request['delivery_date'],
                'description' => $value['description'],
                'count' => $request['count'],
                'price' => $value['price'],
                'status' => 'New',
                'notes' => $request['notes']
            ];
    
            UserOrders::insert($data);
        }
     
    }

    public static function editOrder($request){
        return UserOrders::whereNull('deleted_at')->where('id',$request['order_id'])->update(['pickup_date'=> $request['pickup_date'],'delivery_date'=> $request['delivery_date'],'description'=> $request['description'],'count'=> $request['count'],'price'=> $request['price'],]);
    }

    public static function orderListing($request){

        $noOfRecord = $request['no_of_records'] ?? 10;
        $current_page = $request['page_number'] ?? 1;
        $offset = ($current_page*$noOfRecord)-$noOfRecord;
        $user_id = Auth::User()->id;
        
        $return['total_records'] = UserOrders::whereNull('deleted_at')->where('user_id', $user_id )->count('id');

        $data = UserOrders::whereNull('deleted_at')->where('user_id', $user_id )->offset($offset)->limit($noOfRecord)->get();

        if(count($data)>0){
            $return['order_details'] = $data->toArray();
        }else{
            $return['order_details'] = [];
        }
        return $return;

    }

    public static function updateOrderStatus($request){
       return UserOrders::whereNull('deleted_at')->where('id',$request['order_id'])->update(['status'=> $request['status']]);
    }
}
