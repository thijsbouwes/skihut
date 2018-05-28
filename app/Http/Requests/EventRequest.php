<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'name'       => 'required|max:255',
            'price'      => 'required|numeric|between:0,99999999.99',
            'event_date' => 'required|date_format:Y-m-d',
            'products'   => 'array',
                'products.*.id'       => 'required|exists:products,id',
                'products.*.quantity' => 'required|numeric|between:0,4294967295',
            'users'      => 'array',
                'users.*.id'          => 'required|exists:users,id',
                'users.*.pivot.payed' => 'required|bool'
        ];
    }
}
