<?php


namespace Modules\Form\Jobs;


use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Medeq\Bitrix24\Models\Crm\Deal\Deal;
use Modules\Form\Forms\Form;
use Modules\Form\Services\Bitrix\DealFinder;
use Modules\Form\Services\Bitrix\DealUpdater;
use Modules\Form\Services\Bitrix\DuplicateFinder;
use Modules\Form\Services\Bitrix\LeadCreator;
use Throwable;

/**
 * Class SendToBitrix
 * @package Modules\Form\Jobs
 * @property Form $form
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
     * @throws Throwable
     */
    public function handle(
        DuplicateFinder $duplicateFinder,
        DealFinder $dealFinder,
        DealUpdater $dealUpdater,
        LeadCreator $leadCreator
    )
    {
        $phone = $this->form->getPhone();
        $email = $this->form->getEmail();

        if (!$phone && !$email) {
            throw new Exception("no phone and email");
        }

        if ($this->form->isTestRequest()) {
            $this->toTestDeal();
            return;
        }

        $duplicateFinder
            ->findByPhone($phone)
            ->findByEmail($email);

        $dealFinder
            ->byLeadIds($duplicateFinder->getLeadIds())
            ->byContactIds($duplicateFinder->getContactIds())
            ->byComments($phone, $email);

        if ($dealFinder->deals->isNotEmpty()) {
            $deals = $dealFinder->deals
                ->sortByDesc('id')
                ->unique('id');

            $dealUpdater
                ->setDeals($deals)
                ->setForm($this->form)
                ->update();

            return;
        }

        $leadCreator->setForm($this->form)->create();
    }

    /**
     * @throws Exception
     */
    private function toTestDeal()
    {
        $deal = Deal::find(config('bitrix24.test_deal_id'));

        $deal->addComments(
            $this->form->getComments()
        );

        if (!$deal->save()) {
            throw new Exception("не получилось записать данные в тестовую сделку");
        }
    }
}
