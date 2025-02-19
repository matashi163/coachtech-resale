<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
                'required',
                'image',
                'mimes:png,jpg',
            ],
            'category' => [
                'required',
            ],
            'condision' => [
                'required',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'required',
                'max:255',
            ],
            'price' => [
                'required',
                'integer',
            ],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください',
            'image.image' => '商品画像は画像ファイルを選択してください',
            'image.mimes' => '商品画像は「.png」または「.jpg」を選択してください',
            'category.required' => 'カテゴリーを選択してください',
            'condision.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は整数値で入力してください',
        ];
    }
}
