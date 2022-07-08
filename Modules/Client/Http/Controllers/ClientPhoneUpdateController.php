<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Enums\VerifyType;
use Modules\Client\Http\Requests\ClientPhoneRequest;
use Modules\Client\Http\Requests\ClientPhoneSendCodeRequest;
use Modules\Client\Http\Requests\ClientPhoneVerifyCodeRequest;
use Modules\Client\Models\Client;
use Modules\Client\Services\ClientVerificationService;

class ClientPhoneUpdateController extends Controller
{
    public function __construct(
        protected ClientVerificationService $clientVerificationService
    ){}

    public function validatePhone(ClientPhoneRequest $request)
    {
        return response()->json([]);
    }

    public function sendCode(ClientPhoneSendCodeRequest $request) {
        $verifyType = $request->validated()['verify_type'];

        $this->clientVerificationService->send(
            $request->validated()['phone'],
            VerifyType::fromValue($verifyType),
            auth('client-api')->user()
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function verifyCode(ClientPhoneVerifyCodeRequest $request)
    {
        $phone = $request->validated()['phone'];
        $client = auth('client-api')->user();

        $this->clientVerificationService->setVerifiedAt($client);

        if (!$client->update(['phone' => $phone])) {
            throw new \Exception("Ошибка авторизации, попробуйте позже или обратитесь в поддержку", 401);
        }

        return response()->json([]);
    }
}
