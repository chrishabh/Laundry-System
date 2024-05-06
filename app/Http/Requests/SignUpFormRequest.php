<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpFormRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'user_role' => 'required|in:admin,client',
            'phone_number' => 'required|email|unique:users',
            'address_1' => 'required',
            'address_2' => 'string',
            'city' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'country' => 'required',
            // 'email' => 'required|email|unique:users',
            'password' => 'required',
        ];
    }

    public function messages(){
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'phone_number.required' => 'Phone Number is required',
            'password.required' => 'Password is required',
            'address_1.required' => 'Address is required',
            'city.required' => 'City is required',
            'pincode.required' => 'Pincode is required',
            'state.required' => 'State is required',
            'country.required' => 'Country is required',
        ];
    }
}
