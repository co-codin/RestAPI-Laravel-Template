<?php

namespace Modules\Form\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function build()
    {
        $mail = $this
            ->from('admin@medeq.ru', 'Medeq')
            ->view('form::mail.vacancy-mail')
            ->subject('Новый отклик на вакансию');

        foreach ($this->data['files'] as $file) {
            $mail->attach($file->getRealPath(), [
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
            ]);
        }

        return $mail;
    }
}
