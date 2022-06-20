<?php

namespace Modules\Client\Helpers;

use Illuminate\Support\Facades\Redis;

class CodeVerifyHelper
{
    public static function generateAuthCode(): string
    {
        return (string)random_int(1214, 9897);
    }

    public static function setCode(string $uniqueKey, int $milliseconds = 300, ?string $code = null): string
    {
        $code = $code ?? self::generateAuthCode();

        Redis::set(
            'auth-code-for:' . preg_replace('~\D~', '', $uniqueKey),
            $code,
            'ex',
            $milliseconds
        );

        return $code;
    }

    public static function getCode(string $uniqueKey): ?string
    {
        return Redis::get('auth-code-for:' . preg_replace('~\D~', '', $uniqueKey));
    }

    public static function validateCode(string $uniqueKey, string $codeEnteredByUser): void
    {
        if (Redis::get('auth-code-for:' . preg_replace('~\D~', '', $uniqueKey)) !== $codeEnteredByUser) {
            throw new \Exception("Вы ввели неверный код", 401);
        }
    }
}
