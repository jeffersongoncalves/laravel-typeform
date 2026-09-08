<?php

namespace Jeffersongoncalves\Typeform\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\Client\Response listForms(?int $pageSize = null, ?int $page = null, ?string $workspaceId = null, ?string $search = null)
 * @method static \Illuminate\Http\Client\Response getForm(string $id)
 * @method static \Illuminate\Http\Client\Response createForm(string $title, ?string $workspaceId = null)
 * @method static \Illuminate\Http\Client\Response updateForm(string $id, array $attributes)
 * @method static \Illuminate\Http\Client\Response deleteForm(string $id)
 * @method static \Illuminate\Http\Client\Response listResponses(string $formId, array $filters = [])
 * @method static \Illuminate\Http\Client\Response deleteResponses(string $formId, array $responseIds)
 * @method static \Illuminate\Http\Client\Response listWebhooks(string $formId)
 * @method static \Illuminate\Http\Client\Response getWebhook(string $formId, string $tag)
 * @method static \Illuminate\Http\Client\Response createWebhook(string $formId, string $tag, string $url, bool $enabled = true)
 * @method static \Illuminate\Http\Client\Response deleteWebhook(string $formId, string $tag)
 * @method static \Illuminate\Http\Client\Response listThemes(?int $pageSize = null, ?int $page = null)
 * @method static \Illuminate\Http\Client\Response getTheme(string $id)
 * @method static \Illuminate\Http\Client\Response createTheme(string $name, ?string $font = null)
 * @method static \Illuminate\Http\Client\Response deleteTheme(string $id)
 * @method static \Illuminate\Http\Client\Response listImages()
 * @method static \Illuminate\Http\Client\Response getImage(string $id)
 * @method static \Illuminate\Http\Client\Response listWorkspaces(?int $pageSize = null, ?int $page = null, ?string $search = null)
 * @method static \Illuminate\Http\Client\Response getWorkspace(string $id)
 *
 * @see \Jeffersongoncalves\Typeform\Typeform
 */
class Typeform extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Jeffersongoncalves\Typeform\Typeform::class;
    }
}
