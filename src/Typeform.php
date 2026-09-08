<?php

namespace Jeffersongoncalves\Typeform;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Typeform
{
    public function __construct(
        protected string $apiKey,
        protected string $baseUrl = 'https://api.typeform.com',
    ) {}

    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->apiKey)
            ->acceptJson();
    }

    // --- Forms ---

    public function listForms(?int $pageSize = null, ?int $page = null, ?string $workspaceId = null, ?string $search = null): Response
    {
        return $this->client()->get('/forms', array_filter([
            'page_size' => $pageSize,
            'page' => $page,
            'workspace_id' => $workspaceId,
            'search' => $search,
        ], fn ($value) => $value !== null));
    }

    public function getForm(string $id): Response
    {
        return $this->client()->get("/forms/{$id}");
    }

    public function createForm(string $title, ?string $workspaceId = null): Response
    {
        return $this->client()->post('/forms', array_filter([
            'title' => $title,
            'workspace' => $workspaceId ? ['href' => "https://api.typeform.com/workspaces/{$workspaceId}"] : null,
        ], fn ($value) => $value !== null));
    }

    public function updateForm(string $id, array $attributes): Response
    {
        return $this->client()->put("/forms/{$id}", $attributes);
    }

    public function deleteForm(string $id): Response
    {
        return $this->client()->delete("/forms/{$id}");
    }

    // --- Responses ---

    public function listResponses(string $formId, array $filters = []): Response
    {
        return $this->client()->get("/forms/{$formId}/responses", $filters);
    }

    public function deleteResponses(string $formId, array $responseIds): Response
    {
        return $this->client()->delete("/forms/{$formId}/responses", [
            'included_response_ids' => implode(',', $responseIds),
        ]);
    }

    // --- Webhooks ---

    public function listWebhooks(string $formId): Response
    {
        return $this->client()->get("/forms/{$formId}/webhooks");
    }

    public function getWebhook(string $formId, string $tag): Response
    {
        return $this->client()->get("/forms/{$formId}/webhooks/{$tag}");
    }

    public function createWebhook(string $formId, string $tag, string $url, bool $enabled = true): Response
    {
        return $this->client()->put("/forms/{$formId}/webhooks/{$tag}", [
            'url' => $url,
            'enabled' => $enabled,
        ]);
    }

    public function deleteWebhook(string $formId, string $tag): Response
    {
        return $this->client()->delete("/forms/{$formId}/webhooks/{$tag}");
    }

    // --- Themes ---

    public function listThemes(?int $pageSize = null, ?int $page = null): Response
    {
        return $this->client()->get('/themes', array_filter([
            'page_size' => $pageSize,
            'page' => $page,
        ], fn ($value) => $value !== null));
    }

    public function getTheme(string $id): Response
    {
        return $this->client()->get("/themes/{$id}");
    }

    public function createTheme(string $name, ?string $font = null): Response
    {
        return $this->client()->post('/themes', array_filter([
            'name' => $name,
            'font' => $font,
        ], fn ($value) => $value !== null));
    }

    public function deleteTheme(string $id): Response
    {
        return $this->client()->delete("/themes/{$id}");
    }

    // --- Images ---

    public function listImages(): Response
    {
        return $this->client()->get('/images');
    }

    public function getImage(string $id): Response
    {
        return $this->client()->get("/images/{$id}");
    }

    // --- Workspaces ---

    public function listWorkspaces(?int $pageSize = null, ?int $page = null, ?string $search = null): Response
    {
        return $this->client()->get('/workspaces', array_filter([
            'page_size' => $pageSize,
            'page' => $page,
            'search' => $search,
        ], fn ($value) => $value !== null));
    }

    public function getWorkspace(string $id): Response
    {
        return $this->client()->get("/workspaces/{$id}");
    }
}
