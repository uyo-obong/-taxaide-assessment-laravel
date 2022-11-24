<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{


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
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string',
            'password' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
