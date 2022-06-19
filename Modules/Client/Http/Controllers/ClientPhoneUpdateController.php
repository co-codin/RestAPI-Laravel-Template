<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Enums\VerifyType;
use Modules\Client\Http\Requests\ClientPhoneRequest;
use Modules\Client\Http\Requests\ClientPhoneSendCodeRequest;
use Modules\Client\Models\Client;
use Modules\Client\Services\ClientVerificationService;

class ClientPhoneUpdateController extends Controller
{
    public function validatePhone(ClientPhoneRequest $request)
    {
        return response()->json([]);
    }

    public function sendCode(
        ClientPhoneSendCodeRequest $request,
        ClientVerificationService $clientVerificationService
    ) {
        $phone = $request->validated()['phone'];
        $verifyType = $request->validated()['verify_type'];

        $clientVerificationService->send(
            $phone,
            VerifyType::fromValue($verifyType),
            new Client(['phone' => $phone]),
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function verifyCode()
    {

    }
}
