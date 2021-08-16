<?php


namespace App\Helpers;


class MailHelper
{
    public static function emailsToArray(?string $emails): ?array
    {
        if (is_null($emails)) {
            return null;
        }

        $emailsArray = explode(',', trim($emails,","));

        if (!empty($emailsArray[0])) {
            return $emailsArray;
        }

        return null;
    }
}
