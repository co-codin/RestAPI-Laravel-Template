<?php

namespace Modules\Form\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($data=[])
    {
        $this->data = $data;
    }

    public function build()
    {
        $mail = $this
            ->view('form::mail.vacancy-mail')
            ->subject('Вакансия');

        foreach ($this->data['files'] as $file) {
            $mail->attach($file->getRealPath(), [
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
            ]);
        }

        return $mail;
    }
}
