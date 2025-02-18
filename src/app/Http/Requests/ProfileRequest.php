<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'image' => [
                'image',
                'mimes:png,jpg'
            ],
            'name' => [
                'required',
            ],
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
            'image.image' => '画像を選択してください',
            'image.mimes' => '画像は「.png」または「.jpg」を選択してください',
            'name.required' => '名前を入力してください',
            'name.max' => '名前は255文字以内で入力してください',
            'zip_code.required' => '郵便番号を入力してください',
            'zip_code.digits' => '郵便番号は7桁の数字で入力してください',
            'adress.required' => '住所を入力してください',
            'adress.max' => '住所は255文字以内で入力してください',
            'building' => '建物は255文字以内で入力してください',
        ];
    }
}
