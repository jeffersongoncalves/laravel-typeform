---
name: laravel-typeform-development
description: Build and work with the Laravel Typeform API client, including forms, responses, webhooks, themes, images and workspaces.
---

# Laravel Typeform Development

## When to use this skill

Use this skill when:
- Calling the Typeform API from a Laravel app (forms, responses, webhooks, themes, images, workspaces)
- Configuring the `TYPEFORM_API_KEY` / `TYPEFORM_BASE_URL` environment variables
- Writing tests that mock Typeform HTTP calls

## Core Concepts

### The `Typeform` class

`Jeffersongoncalves\Typeform\Typeform` is bound as a singleton in the container and resolved through `config('typeform.api_key')` / `config('typeform.base_url')`. Every public method sends a request via Laravel's `Http` facade (bearer-authenticated) and returns an `Illuminate\Http\Client\Response`.

```php
use Jeffersongoncalves\Typeform\Facades\Typeform;

$response = Typeform::getForm('formId');

if ($response->successful()) {
    $form = $response->json();
}
```

### Resource coverage

| Resource   | Methods |
|------------|---------|
| Forms      | `listForms`, `getForm`, `createForm`, `updateForm`, `deleteForm` |
| Responses  | `listResponses`, `deleteResponses` |
| Webhooks   | `listWebhooks`, `getWebhook`, `createWebhook`, `deleteWebhook` |
| Themes     | `listThemes`, `getTheme`, `createTheme`, `deleteTheme` |
| Images     | `listImages`, `getImage` |
| Workspaces | `listWorkspaces`, `getWorkspace` |

## Common Patterns

### Filtering responses

```php
Typeform::listResponses($formId, [
    'page_size' => 25,
    'since' => '2026-01-01T00:00:00Z',
    'query' => 'jane@example.com',
]);
```

### Registering a webhook

```php
Typeform::createWebhook($formId, tag: 'my-app', url: 'https://example.com/hooks/typeform', enabled: true);
```

### Testing with `Http::fake()`

```php
use Illuminate\Support\Facades\Http;
use Jeffersongoncalves\Typeform\Facades\Typeform;

Http::fake(['api.typeform.com/forms/*' => Http::response(['id' => 'abc123'])]);

$response = Typeform::getForm('abc123');

Http::assertSent(fn ($request) => $request->url() === 'https://api.typeform.com/forms/abc123');
```

## Troubleshooting

### Error: 401 Unauthorized

**Causa**: missing or invalid `TYPEFORM_API_KEY`.

**Solução**:
```php
// Confirm the token is set and published
config('typeform.api_key');
```

## API Reference

### `Typeform::listForms(?int $pageSize, ?int $page, ?string $workspaceId, ?string $search)`

| Parameter     | Type      | Description                  |
|---------------|-----------|-------------------------------|
| `$pageSize`   | `?int`    | Items per page                |
| `$page`       | `?int`    | Page number                   |
| `$workspaceId`| `?string` | Filter by workspace           |
| `$search`     | `?string` | Search forms by title         |

**Returns**: `Illuminate\Http\Client\Response`
