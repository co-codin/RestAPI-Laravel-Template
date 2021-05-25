<?php


namespace Modules\Form\Services;


use Modules\Form\Forms\Form;
use Modules\Form\Jobs\SendToBitrix;
use Modules\Form\Jobs\SendToCrm;
use Modules\Form\Mail\MailableForm;
use Illuminate\Support\Facades\Bus;
use Modules\Form\Mail\SendDispatchableMail;


class FormSendService
{
    /**
     * @param Form $form
     */
    public function send(Form $form): void
    {
        $this->toExternalApi($form);

        if (
            $form->sendToMail
            && !is_null($form->emails())
            && (!$form->isTestRequest() || config('form.send_test_request'))
        ) {
            $this->toMail($form);
        }
    }

    /**
     * @param Form $form
     */
    private function toExternalApi(Form $form): void
    {
        /*if ($form->sendToCrm) {
            SendToCrm::dispatch($form)
                    ->onQueue('form-to-crm');
        }*/

        if ($form->sendToBitrix) {
            SendToBitrix::dispatch($form)
                ->onQueue('form-to-bitrix');
        }
    }

    /**
     * @param Form $form
     */
    private function toMail(Form $form): void
    {
        $fileAttributeNames = array_keys(request()->allFiles());
        $formWithoutFiles = $form->withoutAttributes($fileAttributeNames);

        $mailableForm = (new MailableForm($formWithoutFiles))
            ->to($form->emails());

        $attachments = \Arr::get($form->attributes(), 'attachments');

        SendDispatchableMail::withChain([
            function () use ($attachments) {
                if (is_array($attachments)) {
                    app(AttachmentService::class)->delete($attachments);
                }
            }
        ])
            ->onQueue('form-to-email')
            ->dispatch($mailableForm);
    }
}
