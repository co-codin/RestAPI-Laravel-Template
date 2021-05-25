<?php


namespace App\Http\Middleware;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class ClientAuthWithPhone
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        try {
            $clientData = $this->getClientData($request);

            $first_name = \Arr::get($clientData, 'first_name');
            $email = \Arr::get($clientData, 'email');
            $phone = \Arr::get($clientData, 'phone');

            if (!$phone) {
                throw new \Exception();
            }

            $request->merge([
                'name' => $first_name,
                'email' => $email,
                'phone' => $phone,
            ]);
        } catch (\Throwable $e) {
            Log::error('Не удалось авторизовать клиента', ['request' => $request->all()]);
            abort(401);
        }

        return $next($request);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    #[ArrayShape([
        'first_name' => "string|null",
        'email' => "string",
        'phone' => "string",
    ])]
    private function getClientData(Request $request): array
    {
        $bearerToken = $request->header('Authorization');

        $client = new Client([
            'base_uri' => config('services.crm.domain'),
            'headers' => ['Authorization' => $bearerToken]
        ]);

        return json_decode(
            $client->get("/clients/me")->getBody(),
            JSON_OBJECT_AS_ARRAY,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
