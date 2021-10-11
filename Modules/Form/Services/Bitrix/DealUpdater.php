<?php


namespace Modules\Form\Services\Bitrix;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Crm\Deal\Deal;
use Medeq\Bitrix24\Models\Im\Notification;
use Medeq\Bitrix24\Models\User\User;
use Modules\Form\Forms\Form;

/**
 * Class DealUpdater
 * @package Modules\Form\Services\Bitrix
 * @property ManagerService $managerService
 * @property Deal[]|Collection $deals
 * @property Form $form
 * @property array $notifiedUsers
 */
class DealUpdater
{
    private $managerService;
    private $deals;
    private $form;
    private $notifiedUsers = [];

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    /**
     * @param Collection $deals
     * @return $this
     */
    public function setDeals(Collection $deals): self
    {
        $this->deals = $deals;

        return $this;
    }

    /**
     * @param Form $form
     * @return DealUpdater
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function update()
    {
        $assignedByIds = $this->deals->pluck('assigned_by_id');

        $firstDeal = $this->getFirstDeal();

        if ($firstDeal->alreadyInTurn()) {
            $firstDeal->addComments($this->form->getComments())->save();
            return;
        }

        if ($this->dealsHasOnlyBots($assignedByIds)) {
            $this->changeManagerForBotDeal($firstDeal);
            return;
        }

        $moreThanOneRealUser = $this->dealHasMoreThanOneRealUser($assignedByIds);

        $messageTemplate = "Повторная заявка по сделке [url=" . config('bitrix24.domain') . "/crm/deal/show/{{ id }}/]{{ title }}[/url]";

        foreach ($this->deals as $deal) {

            $receiverId = $deal->assigned_by_id;

            if ($this->notificationAlreadySent($receiverId)) {
                continue;
            }

            if ($this->managerIsBot($receiverId)) {
                $receiverId = $this->getBotHeadUserIds($receiverId);
            }

            $message = strtr($messageTemplate, ['{{ id }}' => $deal->id, '{{ title }}' => $deal->title]);

            if ($moreThanOneRealUser) {
                $message .= $this->renderMoreThanOneRealUserTemplate($assignedByIds);
            }

            $this->sendNotifications($receiverId, $message);
            $deal->addComments($this->form->getComments())->save();
        }
    }

    protected function getFirstDeal(): Deal
    {
        return $this->deals->first();
    }

    /**
     * @param Collection $assignedByIds
     * @return bool
     */
    private function dealsHasOnlyBots(Collection $assignedByIds): bool
    {
        return $assignedByIds->diff($this->managerService->getBotIds())->isEmpty();
    }

    /**
     * @param Deal $deal
     * @throws \Exception
     */
    private function changeManagerForBotDeal(Deal $deal)
    {
        $deal->assigned_by_id = ! $this->form->getPhone()
            ? config('bitrix24.no_phone_deal_assigned_id')
            : config('bitrix24.repeat_deal_assigned_id');

        $deal->addComments($this->form->getComments());

        if (!$deal->save()) {
            throw new \Exception("Не получилось сохранить сделку");
        }
    }

    /**
     * @param Collection $assignedByIds
     * @return bool
     */
    protected function dealHasMoreThanOneRealUser(Collection $assignedByIds): bool
    {
        return $assignedByIds->unique()
                ->intersect($this->managerService->getRealUserIds())
                ->count() > 1;
    }

    /**
     * @param string $managerId
     * @return bool
     */
    private function notificationAlreadySent(string $managerId): bool
    {
        return in_array($managerId, $this->notifiedUsers);
    }

    /**
     * @param array|int[] $receiverIds
     * @param string $message
     */
    private function sendNotifications($receiverIds, string $message)
    {
        foreach (Arr::wrap($receiverIds) as $receiverId) {
            $this->sendNotification($receiverId, $message);
        }
    }

    /**
     * @param int $receiverId
     * @param string $message
     */
    private function sendNotification(int $receiverId, string $message)
    {
        Notification::make()->to($receiverId)->system()->message($message)->send();
        $this->notifiedUsers[] = $receiverId;
    }

    /**
     * @param string $managerId
     * @return bool
     */
    private function managerIsBot(string $managerId)
    {
        return in_array($managerId, $this->managerService->getBotIds()->toArray());
    }

    /**
     * @param string $receiverId
     * @return string|null
     */
    private function getBotHeadUserIds(string $receiverId): ? array
    {
        $bots = $this->managerService->getBots();

        /** @var User $bot */
        $bot = Arr::get($bots, $receiverId);

        return $this->managerService
            ->getSaleDepartments()
            ->keyBy('id')
            ->whereIn('id', $bot->uf_department)
            ->pluck('uf_head')
            ->filter()
            ->toArray();

//        return Arr::get($this->managerService->getSaleDepartments()->keyBy('id')[$department], "uf_head");
    }

    /**
     * @param Collection $assignedByIds
     * @return string
     */
    protected function renderMoreThanOneRealUserTemplate(Collection $assignedByIds): string
    {
        $message = ". C этим клиентом работают: ";

        $message .= $assignedByIds
            ->filter(function ($id) {
                return Arr::has($this->managerService->getUsers(), $id);
            })->map(function ($id) {
                $user = Arr::get($this->managerService->getUsers(), $id);
                return $user->name . " " . $user->last_name;
            })
            ->join(', ');

        return $message;
    }
}
