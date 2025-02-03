<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdressRequest extends FormRequest
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
            'zip_code' => [
                'required',
                'digits:7',
            ],
            'adress' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'zip_code.required' => '郵便番号が入力されていません',
            'zip_code.digits' => '郵便番号は7桁の数字で入力してください',
            'adress.required' => '住所が入力されていません',
        ];
    }
}
