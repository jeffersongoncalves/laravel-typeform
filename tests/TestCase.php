<?php

namespace Jeffersongoncalves\Typeform\Tests;

use Jeffersongoncalves\Typeform\TypeformServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            TypeformServiceProvider::class,
        ];
    }
}
