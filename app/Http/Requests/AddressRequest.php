<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this Request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the Request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'first_name' => 'required|max:255',
	        'last_name' => 'required|max:255',
	        'email' => 'required|email',
	        'phone' => 'required',
	        'address1' => 'required|max:255',
	        'address2' => 'max:255',
	        'city' => 'required|max:255',
	        'state' => 'required|integer'
        ];
    }
}
