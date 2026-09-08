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

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('typeform.api_key', 'fake-api-key');
        $app['config']->set('typeform.base_url', 'https://api.typeform.com');
    }
}
