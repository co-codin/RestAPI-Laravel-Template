<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Enums\VerifyType;
use Modules\Client\Http\Requests\ClientEmailSendCodeRequest;
use Modules\Client\Http\Requests\ClientEmailVerifyCodeRequest;
use Modules\Client\Models\Client;
use Modules\Client\Services\ClientVerificationService;

class ClientEmailUpdateController extends Controller
{
    public function __construct(
        protected ClientVerificationService $clientVerificationService
    ){}

    public function send(ClientEmailSendCodeRequest $request)
    {
        $this->clientVerificationService->send(
            $request->validated()['email'],
            VerifyType::fromValue(VerifyType::EMAIL),
            auth('client-api')->user()
        );

        return response()->json();
    }

    public function verify(ClientEmailVerifyCodeRequest $request)
    {
        $client = auth('client-api')->user();

        if (!$client->update(['email' => $request->validated()['email']])) {
            throw new \Exception("Ошибка авторизации, попробуйте позже или обратитесь в поддержку", 401);
        }

        return response()->json([]);
    }
}
