<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Jeffersongoncalves\Typeform\Facades\Typeform;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('lists forms', function () {
    Http::fake(['api.typeform.com/forms*' => Http::response(['items' => []])]);

    $response = Typeform::listForms(pageSize: 10, page: 1, workspaceId: 'ws1', search: 'foo');

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && str_starts_with($request->url(), 'https://api.typeform.com/forms')
        && $request['page_size'] === 10
        && $request['page'] === 1
        && $request['workspace_id'] === 'ws1'
        && $request['search'] === 'foo'
        && $request->hasHeader('Authorization', 'Bearer fake-api-key'));
});

it('gets a form', function () {
    Http::fake(['api.typeform.com/forms/abc123' => Http::response(['id' => 'abc123'])]);

    $response = Typeform::getForm('abc123');

    expect($response->json('id'))->toBe('abc123');
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/forms/abc123');
});

it('creates a form', function () {
    Http::fake(['api.typeform.com/forms' => Http::response(['id' => 'new123'], 201)]);

    $response = Typeform::createForm('My Form', 'ws1');

    expect($response->status())->toBe(201);
    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->url() === 'https://api.typeform.com/forms'
        && $request['title'] === 'My Form'
        && $request['workspace']['href'] === 'https://api.typeform.com/workspaces/ws1');
});

it('updates a form', function () {
    Http::fake(['api.typeform.com/forms/abc123' => Http::response(['id' => 'abc123'])]);

    $response = Typeform::updateForm('abc123', ['title' => 'Updated']);

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'PUT'
        && $request->url() === 'https://api.typeform.com/forms/abc123'
        && $request['title'] === 'Updated');
});

it('deletes a form', function () {
    Http::fake(['api.typeform.com/forms/abc123' => Http::response([], 204)]);

    $response = Typeform::deleteForm('abc123');

    expect($response->status())->toBe(204);
    Http::assertSent(fn (Request $request) => $request->method() === 'DELETE'
        && $request->url() === 'https://api.typeform.com/forms/abc123');
});

it('lists responses', function () {
    Http::fake(['api.typeform.com/forms/abc123/responses*' => Http::response(['items' => []])]);

    $response = Typeform::listResponses('abc123', ['page_size' => 5, 'since' => '2026-01-01T00:00:00Z']);

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && str_starts_with($request->url(), 'https://api.typeform.com/forms/abc123/responses')
        && $request['page_size'] === 5
        && $request['since'] === '2026-01-01T00:00:00Z');
});

it('deletes responses', function () {
    Http::fake(['api.typeform.com/forms/abc123/responses*' => Http::response([], 204)]);

    $response = Typeform::deleteResponses('abc123', ['r1', 'r2']);

    expect($response->status())->toBe(204);
    Http::assertSent(fn (Request $request) => $request->method() === 'DELETE'
        && str_starts_with($request->url(), 'https://api.typeform.com/forms/abc123/responses')
        && $request['included_response_ids'] === 'r1,r2');
});

it('lists webhooks', function () {
    Http::fake(['api.typeform.com/forms/abc123/webhooks' => Http::response(['items' => []])]);

    $response = Typeform::listWebhooks('abc123');

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/forms/abc123/webhooks');
});

it('gets a webhook', function () {
    Http::fake(['api.typeform.com/forms/abc123/webhooks/mytag' => Http::response(['tag' => 'mytag'])]);

    $response = Typeform::getWebhook('abc123', 'mytag');

    expect($response->json('tag'))->toBe('mytag');
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/forms/abc123/webhooks/mytag');
});

it('creates a webhook', function () {
    Http::fake(['api.typeform.com/forms/abc123/webhooks/mytag' => Http::response(['tag' => 'mytag'])]);

    $response = Typeform::createWebhook('abc123', 'mytag', 'https://example.com/hook');

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'PUT'
        && $request->url() === 'https://api.typeform.com/forms/abc123/webhooks/mytag'
        && $request['url'] === 'https://example.com/hook'
        && $request['enabled'] === true);
});

it('deletes a webhook', function () {
    Http::fake(['api.typeform.com/forms/abc123/webhooks/mytag' => Http::response([], 204)]);

    $response = Typeform::deleteWebhook('abc123', 'mytag');

    expect($response->status())->toBe(204);
    Http::assertSent(fn (Request $request) => $request->method() === 'DELETE'
        && $request->url() === 'https://api.typeform.com/forms/abc123/webhooks/mytag');
});

it('lists themes', function () {
    Http::fake(['api.typeform.com/themes*' => Http::response(['items' => []])]);

    $response = Typeform::listThemes(pageSize: 20, page: 2);

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && str_starts_with($request->url(), 'https://api.typeform.com/themes')
        && $request['page_size'] === 20
        && $request['page'] === 2);
});

it('gets a theme', function () {
    Http::fake(['api.typeform.com/themes/theme1' => Http::response(['id' => 'theme1'])]);

    $response = Typeform::getTheme('theme1');

    expect($response->json('id'))->toBe('theme1');
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/themes/theme1');
});

it('creates a theme', function () {
    Http::fake(['api.typeform.com/themes' => Http::response(['id' => 'theme1'], 201)]);

    $response = Typeform::createTheme('My Theme', 'Arial');

    expect($response->status())->toBe(201);
    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->url() === 'https://api.typeform.com/themes'
        && $request['name'] === 'My Theme'
        && $request['font'] === 'Arial');
});

it('deletes a theme', function () {
    Http::fake(['api.typeform.com/themes/theme1' => Http::response([], 204)]);

    $response = Typeform::deleteTheme('theme1');

    expect($response->status())->toBe(204);
    Http::assertSent(fn (Request $request) => $request->method() === 'DELETE'
        && $request->url() === 'https://api.typeform.com/themes/theme1');
});

it('lists images', function () {
    Http::fake(['api.typeform.com/images' => Http::response(['items' => []])]);

    $response = Typeform::listImages();

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/images');
});

it('gets an image', function () {
    Http::fake(['api.typeform.com/images/img1' => Http::response(['id' => 'img1'])]);

    $response = Typeform::getImage('img1');

    expect($response->json('id'))->toBe('img1');
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/images/img1');
});

it('lists workspaces', function () {
    Http::fake(['api.typeform.com/workspaces*' => Http::response(['items' => []])]);

    $response = Typeform::listWorkspaces(pageSize: 10, page: 1, search: 'team');

    expect($response->successful())->toBeTrue();
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && str_starts_with($request->url(), 'https://api.typeform.com/workspaces')
        && $request['page_size'] === 10
        && $request['page'] === 1
        && $request['search'] === 'team');
});

it('gets a workspace', function () {
    Http::fake(['api.typeform.com/workspaces/ws1' => Http::response(['id' => 'ws1'])]);

    $response = Typeform::getWorkspace('ws1');

    expect($response->json('id'))->toBe('ws1');
    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://api.typeform.com/workspaces/ws1');
});
