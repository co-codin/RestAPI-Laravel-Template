<?php

namespace Modules\Client\Helpers;

class PhoneHelper
{
    public static function format(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) === 11) {
            $phone = preg_replace('/^8/', 7, $phone);
        }

        if (strlen($phone) === 10 && preg_match('/^9/', $phone, $matches)) {
            $phone = '7' . $phone;
        }

        return '+' . $phone;
    }
}
