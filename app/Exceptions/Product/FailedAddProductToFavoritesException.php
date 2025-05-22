<?php

namespace App\Exceptions\Product;

use App\Exceptions\BusinessLogicException;

class FailedAddProductToFavoritesException extends BusinessLogicException
{
    public function __construct()
    {
        $this->code    = self::FAILED_ADD_PRODUCT_TO_FAVORITES;
        $this->message = __('errors.failed_add_product_to_favorites');

        parent::__construct($this->message, $this->code);
    }
}
