<?php

namespace App\Exceptions;

abstract class BusinessLogicException extends \Exception
{
    public const FAILED_ADD_PRODUCT_TO_FAVORITES = 601;
}
