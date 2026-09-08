<?php

use Jeffersongoncalves\Typeform\Facades\Typeform as TypeformFacade;
use Jeffersongoncalves\Typeform\Typeform;

it('registers the typeform singleton', function () {
    expect(app(Typeform::class))->toBeInstanceOf(Typeform::class);
    expect(app(Typeform::class))->toBe(app(Typeform::class));
});

it('resolves the facade to the typeform class', function () {
    expect(TypeformFacade::getFacadeRoot())->toBeInstanceOf(Typeform::class);
});

it('merges the package config', function () {
    expect(config('typeform.base_url'))->toBe('https://api.typeform.com');
});
