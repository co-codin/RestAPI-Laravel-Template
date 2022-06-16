<?php

namespace Modules\Client\Services;

use Modules\Client\Enums\VerifyType;
use Modules\Client\Helpers\CodeVerifyHelper;
use Modules\Client\Models\Client;
use Illuminate\Support\Facades\Mail;

class ClientVerificationService
{
    public function send(string $uniqueKey, VerifyType $verifyType, Client $client): void
    {
        $code = CodeVerifyHelper::setCode($uniqueKey);

        if ($verifyType->value === VerifyType::EMAIL) {
            /** $uniqueKey - email */
            Mail::raw("Код подтверждения: {$code}", function ($message) use ($uniqueKey) {
                $message->to($uniqueKey)->subject("Код подтверждения");
            });

            return;
        }

        $channel = match ($verifyType->value) {
            VerifyType::VOICE => SmscRuVoiceChannel::class,
            VerifyType::SMS => SmscRuSmsChannel::class,
        };

        Client::unguard();
        $client = new Client(['phone' => $client->phone]);
        $client->notifyNow(new PhoneVerifyNotification(), [$channel]);
    }

    /**
     * @throws VerifyException
     */
    public function verify(string $uniqueKey, string $code): void
    {
        CodeVerifyHelper::validateCode($uniqueKey, $code);
    }

    /**
     * @throws \Exception
     */
    public function setVerifiedAt(Client $client): void
    {
        $client->phone_verified_at = Carbon::now();

        if (!$client->save()) {
            throw new \Exception("Ошибка авторизации, попробуйте позже или обратитесь в поддержку", 401);
        }
    }
}
