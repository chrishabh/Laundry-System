<?php

namespace App\Http\Requests;

use App\Enums\Constants;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderFormRequest extends FormRequest
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
            'pickup_date' => 'required',
            'delivery_date' => 'required',
            'items' => 'required|array',
            'items.*.description' => 'required',
            'items.*.price' => 'required',
            'count' => 'required',
            'notes' => 'nullable',
            //'status' => 'required',
           
        ];
      
      
    }

    public function messages(){
        return [
            'pickup_date.required' => 'Pick Up Date is required',
            'delivery_date.required' => 'Delivery Date is required',
            'items.*.description.required' => 'Description Id is required',
            'count.required' => 'Count is required',
            'items.*.price.required' => 'Price is required',
            'status.required' => 'Statue Id is required',
        ];
    }
}
