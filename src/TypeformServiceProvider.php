<?php

namespace Jeffersongoncalves\Typeform;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TypeformServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-typeform')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Typeform::class, fn () => new Typeform(
            apiKey: (string) config('typeform.api_key'),
            baseUrl: (string) config('typeform.base_url'),
        ));
    }
}
