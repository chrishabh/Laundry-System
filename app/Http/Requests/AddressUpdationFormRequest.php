<?php

namespace App\Http\Requests;

use App\Enums\Constants;
use Illuminate\Foundation\Http\FormRequest;

class AddressUpdationFormRequest extends FormRequest
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
        switch($this->path()){

            case Constants::ADD_ADDRESS:
                return [
                    'address_1' => 'required',
                    'address_2' => 'string',
                    'city' => 'required',
                    'pincode' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'default' => 'required|in:0,1',
                ];
            break;

            case Constants::EDIT_ADDRESS:
                return [
                    'address_id' => 'required',
                    'address_1' => 'required',
                    'address_2' => 'string',
                    'city' => 'required',
                    'pincode' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'default' => 'required|in:0,1',
                ];
            break;

            case Constants::DELETE_ADDRESS:
                return [
                    'address_id' => 'required',

                ];
            break;
        }
    }

    public function messages(){
        return [
            'address_1.required' => 'Address is required',
            'city.required' => 'City is required',
            'pincode.required' => 'Pincode is required',
            'state.required' => 'State is required',
            'country.required' => 'Country is required',
            'default.required' => 'Default is required',
            'address_id.required'    => 'Address id is required'

        ];
    }
}
