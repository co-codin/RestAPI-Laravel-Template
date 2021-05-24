<?php

namespace Modules\Form\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Form\Forms\Form;

/**
 * Class Send
 * @package Modules\Form\Mail
 */
class MailableForm extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    public function __construct(
        private Form $form
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this
            ->view('form::mail.send-form', ['form' => $this->form])
            ->subject($this->form->emailSubject());
//            ->html($this->form->emailBody());

        $attributes = $this->form->attributes();
        $attachmentPaths = \Arr::get($attributes, 'attachments');

        if (!is_null($attachmentPaths)) {
            foreach ($attachmentPaths as $path) {
                $mail->attachFromStorage($path);
            }
        }

        return $mail;
    }
}
