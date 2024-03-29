<?php

namespace App\Http\Requests;

use App\Rules\LessThan;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'regular_price' => 'required|numeric|min:1',
            'sale_price' => ['nullable', 'numeric', 'min:1', new LessThan(request('regular_price'))],
        ];
    }
}
