<?php

namespace Modules\Client\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Client\Helpers\CodeVerifyHelper;
use Modules\Client\Notifications\Messages\ProstorSmsMessage;
use NotificationChannels\SmscRu\SmscRuMessage;

class PhoneVerifyNotification extends Notification
{
    use Queueable;

    public function via(mixed $notifiable): array|string
    {
        return array_keys($notifiable->routes);
    }

    public function toProstorSms(mixed $notifiable): ProstorSmsMessage
    {
        $code = CodeVerifyHelper::getCode($notifiable->phone);
        return ProstorSmsMessage::create("Код авторизации $code");
    }

    public function toSmscRu(mixed $notifiable): SmscRuMessage
    {
        $code = CodeVerifyHelper::getCode($notifiable->phone);
        return SmscRuMessage::create("Код авторизации $code");
    }
}
