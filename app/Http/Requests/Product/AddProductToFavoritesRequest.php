<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class AddProductToFavoritesRequest extends FormRequest
{
    public const PRODUCT_ID = 'product_id';

    public function rules(): array
    {
        return [
            self::PRODUCT_ID => [
                'int',
                'required',
                'exists:products,id'
            ],
        ];
    }
}
