## Laravel Typeform

This package provides a typed wrapper around the [Typeform API](https://developer.typeform.com/) for forms, responses, webhooks, themes, images and workspaces.

### Installation

@verbatim
<code-snippet name="Install the package" lang="bash">
composer require jeffersongoncalves/laravel-typeform
php artisan vendor:publish --tag="laravel-typeform-config"
</code-snippet>
@endverbatim

Set `TYPEFORM_API_KEY` in `.env` to a Typeform personal access token.

### Features

- **Forms**: list, get, create, update and delete forms.
- **Responses**: list and bulk-delete form responses, with filters (`page_size`, `since`, `until`, `query`, ...).
- **Webhooks**: manage webhooks per form (list, get, create/update via `PUT`, delete).
- **Themes**, **Images** and **Workspaces**: read/manage helpers mirroring the Typeform REST API.

@verbatim
<code-snippet name="Fetch a form's responses" lang="php">
use Jeffersongoncalves\Typeform\Facades\Typeform;

$response = Typeform::listResponses($formId, ['page_size' => 25]);

$items = $response->json('items');
</code-snippet>
@endverbatim

### Configuration

@verbatim
<code-snippet name="Config example" lang="php">
// config/typeform.php
return [
    'api_key' => env('TYPEFORM_API_KEY'),
    'base_url' => env('TYPEFORM_BASE_URL', 'https://api.typeform.com'),
];
</code-snippet>
@endverbatim

### Best Practices

- Every method returns an `Illuminate\Http\Client\Response` — check `->successful()`/`->status()` before trusting `->json()`.
- Use `Http::fake()` in tests instead of hitting the real Typeform API; the package resolves its HTTP client through Laravel's `Http` facade.
