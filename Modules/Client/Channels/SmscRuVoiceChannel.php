<?php

namespace Modules\Client\Channels;

use Illuminate\Notifications\Notification;
use NotificationChannels\SmscRu\Exceptions\CouldNotSendNotification;
use NotificationChannels\SmscRu\SmscRuApi;
use NotificationChannels\SmscRu\SmscRuMessage;

class SmscRuVoiceChannel
{
    public function __construct(
        protected SmscRuApi $smscRuApi
    ) {}

    public function send($notifiable, Notification $notification): ?array
    {
        if (!($to = $this->getRecipients($notifiable, $notification))) {
            return null;
        }

        $message = $notification->{'toSmscRuVoiceCall'}($notifiable);

        if (\is_string($message)) {
            $message = new SmscRuMessage($message);
        }

        return $this->sendMessage($to, $message);
    }
    
    protected function getRecipients($notifiable, Notification $notification): array
    {
        $to = $notifiable->routeNotificationFor('smscru', $notification);

        if (empty($to)) {
            return [];
        }

        return \is_array($to) ? $to : [$to];
    }

    protected function sendMessage($recipients, SmscRuMessage $message)
    {
        if (\mb_strlen($message->content) > 60) {
            throw CouldNotSendNotification::contentLengthLimitExceeded();
        }

        $params = [
            'phones' => \implode(',', $recipients),
            'mes' => $message->content,
            'sender' => $message->from,
            'call' => 1,
        ];

        if ($message->sendAt instanceof \DateTimeInterface) {
            $params['time'] = '0' . $message->sendAt->getTimestamp();
        }

        return $this->smscRuApi->send($params);
    }
}
