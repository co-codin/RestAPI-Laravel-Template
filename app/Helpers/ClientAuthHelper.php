<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;

class ClientAuthHelper
{
    private ?array $clientData = null;

    #[ArrayShape([
        'auth_name' => "string|null",
        'auth_phone' => "string|null",
        'auth_email' => "string|null",
        'auth_id' => "string|null",
    ])]
    public function getClientData(): array
    {
        if (!is_null($this->clientData)) {
            return $this->clientData;
        }

        $this->setClientData(request()->client);

        return $this->clientData;
    }

    public function setClientData(?array $clientData = null): self
    {
        $name = \Arr::get($clientData,'first_name') . ' ' . \Arr::get($clientData,'last_name');

        $this->clientData = [
            'auth_name' => !empty(trim($name)) ? $name : null,
            'auth_phone' => $clientData['phone'] ?? null,
            'auth_email' => $clientData['email'] ?? null,
            'auth_id' => $clientData['id'] ?? null,
        ];

        return $this;
    }

    public static function authorize(Request $request): void
    {
        $response = Http::baseUrl(config('services.crm.domain'))
            ->withToken($request->bearerToken())
            ->get('/clients/show');

        if ($response->failed()) {
            abort(401);
        }

        $request->offsetSet('client', $response->json());
    }
}
