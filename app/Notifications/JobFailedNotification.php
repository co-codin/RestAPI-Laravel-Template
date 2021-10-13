<?php

namespace App\Notifications;

use App\Helpers\ExceptionHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\Events\JobFailed;

/**
 * Class JobFailedNotifiable
 * @package App\Notifications
 * @property JobFailed $event
 */
class JobFailedNotification extends Notification
{
    use Queueable;

    private $event;

    /**
     * Create a new notification instance.
     *
     * @param JobFailed $event
     */
    public function __construct(JobFailed $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
    //     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $exceptionTraceHtml = ExceptionHelper::toHtml($this->event->exception);

        return (new MailMessage)->view('emails.send-job-failed', [
            'exception' => $this->event->exception,
            'job' => $this->event->job,
            'css' => $exceptionTraceHtml['css'],
            'content' => $exceptionTraceHtml['content'],
        ])
            ->subject('Exception: ' . \Request::fullUrl());
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->error()
            ->from('Excuseme!', ':excuse:')
            ->to('#medeqstars-monitoring')
            ->content('Job ' . $this->event->job->resolveName() . ' is Failed.')
            ->attachment(function (SlackAttachment $attachment)  {
                $attachment
                    ->fallback('Job failed on v2.medeq.ru')
                    ->title('Exception')
                    ->content($this->event->exception->getMessage())
                    ->fields([
                        'File:' => $this->event->exception->getFile(),
                        'Code:' => $this->event->exception->getCode(),
                        'Line:' => $this->event->exception->getLine(),
                    ]);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
