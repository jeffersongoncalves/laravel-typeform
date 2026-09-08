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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
