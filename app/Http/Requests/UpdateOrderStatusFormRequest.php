<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusFormRequest extends FormRequest
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
            'order_id'            =>  'required',
           'status'   =>  'required|in:New,In-Progress,Out for Delivery,Delivered'
        ];
    }

    public function messages(){
        return [
            'id.required' => 'User id field is required',
            'status.required' => 'Status field is required',
        ];
    }
}
