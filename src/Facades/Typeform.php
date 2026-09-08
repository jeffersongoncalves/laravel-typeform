<?php

namespace Jeffersongoncalves\Typeform\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\Typeform\Typeform
 */
class Typeform extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-typeform';
    }
}
