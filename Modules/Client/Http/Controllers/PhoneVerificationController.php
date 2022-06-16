<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
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
    }

    public function verifyCode(ClientVerifyCodeRequest $request)
    {

    }
}
