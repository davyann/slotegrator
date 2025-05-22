<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ListRequest;

class ProductIndexRequest extends ListRequest
{
    public const CATEGORY = 'category';

    public function rules(): array
    {
        return array_merge(
            parent::rules(), [
                self::CATEGORY => [
                    'string',
                    'nullable',
                ],
            ]
        );
    }
    public function getCategory() : ?string
    {
        return $this->get(self::CATEGORY);
    }
}
