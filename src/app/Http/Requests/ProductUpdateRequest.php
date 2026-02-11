<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0', 'max:10000'],
            'image' => [
                'nullable',
                'file',
                'mimetypes:image/png,image/jpeg',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (!in_array($ext, ['png', 'jpeg'], true)) {
                        $fail('「.png」または「.jpeg」形式でアップロードしてください');
                    }
                },
            ],
            'seasons' => ['required', 'array', 'min:1'],
            'seasons.*' => ['integer', Rule::exists('seasons', 'id')],
            'description' => ['required', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',

            'price.required' => '値段を入力してください',
            'price.integer'  => '数値で入力してください',
            'price.min'      => '0∼10000円以内で入力してください',
            'price.max'      => '0∼10000円以内で入力してください',

            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',

            'seasons.required' => '季節を選択してください',
            'seasons.array'    => '季節を選択してください',
            'seasons.min'      => '季節を選択してください',
            'seasons.*.exists' => '季節を選択してください',

            'description.required' => '商品説明を入力してください',
            'description.max'      => '120文字以内で入力してください',
        ];
    }
}
