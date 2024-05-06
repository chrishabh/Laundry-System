<?php

namespace App\Http\Requests;

use App\Enums\Constants;
use Illuminate\Foundation\Http\FormRequest;

class EditOrderFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return [
            'order_id'  => 'required',
            'pickup_date' => 'required',
            'delivery_date' => 'required',
            'description' => 'required',
            'count' => 'required',
            'price' => 'required',
            // 'status' => 'required',
           
        ];
      
      
    }

    public function messages(){
        return [
            'order_id.required' => 'Order Id is required',
            'pickup_date.required' => 'Pick Up Date is required',
            'delivery_date.required' => 'Delivery Date is required',
            'description.required' => 'Description Id is required',
            'count.required' => 'Count is required',
            'price.required' => 'Price is required',
            'status.required' => 'Statue Id is required',
        ];
    }
}
