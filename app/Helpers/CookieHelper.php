<?php


namespace App\Helpers;


class CookieHelper
{
    /**
     * @param mixed $cookie
     * @return mixed
     */
    public static function getDecryptedCookie(mixed $cookie): mixed
    {
        if (is_array($cookie)) {
            return collect($cookie)->map(function ($item) {
                return \Crypt::decrypt($item, false);
            })->toArray();
        }

        return \Crypt::decrypt($cookie, false);
    }

    /**
     * @param mixed $cookie
     * @return mixed
     * @throws \JsonException
     */
    public static function getDecodedJsonCookie(mixed $cookie): mixed
    {
        if(!is_string($cookie)) {
            return $cookie;
        }

        return json_decode($cookie, JSON_OBJECT_AS_ARRAY, 512, JSON_THROW_ON_ERROR);
    }
}
