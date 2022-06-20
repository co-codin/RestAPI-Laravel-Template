<?php


namespace Modules\Client\Notifications\Messages;

use DateTimeInterface;

class ProstorSmsMessage
{
    public string $from = '';

    public string $content = '';

    public ?DateTimeInterface $sendAt;

    public static function create(string $content = ''): self
    {
        return new static($content);
    }

    public function __construct(string $content = '')
    {
        $this->content = $content;
        $this->from = config('auth.prostor.sender');
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function sendAt(DateTimeInterface $sendAt = null): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }
}
