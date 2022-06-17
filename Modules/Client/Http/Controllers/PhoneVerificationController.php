<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Enums\VerifyType;
use Modules\Client\Http\Requests\ClientSendCodeRequest;
use Modules\Client\Http\Requests\ClientVerifyCodeRequest;
use Modules\Client\Models\Client;
use Modules\Client\Services\ClientVerificationService;

class PhoneVerificationController extends Controller
{
    public function sendCode(
        ClientSendCodeRequest $request,
        ClientVerificationService $clientVerificationService
    )
    {
        $phone = $request->validated()['phone'];

        $verifyType = $request->validated()['verify_type'];

        $client = Client::wherePhone($phone)->first()
            ?? throw new \Exception('Пользователь не найден');

        abort_if((bool)$client->banned_at, 403, 'Пользователь с указанным номером заблокирован');

        $clientVerificationService->send(
            $client->phone,
            VerifyType::fromValue($verifyType),
            $client,
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function verifyCode(
        ClientVerifyCodeRequest $request,
        ClientVerificationService $clientVerificationService
    ) {
        $client = Client::wherePhone($request->validated()['phone'])->first();

        $clientVerificationService->setVerifiedAt($client);

        auth('client-api')->login($client);

        $token = auth('client-api')->user()->createToken('API Token')->plainTextToken;

        $bearerTokenResponse = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl
        ];

        return response()->json(
            array_merge(['success' => true], $bearerTokenResponse)
        );
    }
}
