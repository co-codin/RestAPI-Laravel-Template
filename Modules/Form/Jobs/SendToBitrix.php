<?php


namespace Modules\Form\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Form\Forms\Form;
use Throwable;

/**
 * Class SendToBitrix
 * @package Modules\Form\Jobs
 */
class SendToBitrix implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    /**
     * SendToBitrix constructor.
     * @param Form $form
     */
    public function __construct(
        private Form $form
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
//        $phone = $this->form->getPhone();
//        $email = $this->form->getEmail();
//
//        if (!$phone && !$email) {
//            throw new Exception("no phone and email");
//        }
//
//        if ($this->form->isTestRequest()) {
//            $this->toTestDeal();
//            return;
//        }
    }
}
