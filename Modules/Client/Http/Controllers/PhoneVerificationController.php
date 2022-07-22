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
    public function __construct(
        protected ClientVerificationService $clientVerificationService
    ){}

    public function sendCode(ClientSendCodeRequest $request)
    {
        $phone = $request->validated()['phone'];

        $verifyType = (int) $request->validated()['verify_type'];

        $client = Client::wherePhone($phone)->first()
            ?? throw new \Exception('Пользователь не найден');

        abort_if((bool)$client->banned_at, 403, 'Пользователь с указанным номером заблокирован');

        $this->clientVerificationService->send(
            $client->phone,
            VerifyType::fromValue($verifyType),
            $client,
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function verifyCode(ClientVerifyCodeRequest $request) {
        $client = Client::wherePhone($request->validated()['phone'])->first();

        $this->clientVerificationService->setVerifiedAt($client);

        $token = $client->createToken('API Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'success' => true
        ]);
    }
}
