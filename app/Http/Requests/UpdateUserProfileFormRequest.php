<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileFormRequest extends FormRequest
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
            'address' => 'required|array',
            'address.*.address_1' => 'required',
            'address.*.address_2' => 'string',
            'address.*.city' => 'required',
            'address.*.pincode' => 'required',
            'address.*.state' => 'required',
            'address.*.country' => 'required',
            'address.*.default' => 'required|in:0,1',
        ];
    }

    public function messages(){
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'address.*.address_1.required' => 'Address is required',
            'address.*.city.required' => 'City is required',
            'address.*.pincode.required' => 'Pincode is required',
            'address.*.state.required' => 'State is required',
            'address.*.country.required' => 'Country is required',
            'address.*.default.required' => 'Default is required',

        ];
    }
}
