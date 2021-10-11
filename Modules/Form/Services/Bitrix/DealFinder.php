<?php


namespace Modules\Form\Services\Bitrix;

use Illuminate\Support\Collection;
use Modules\Form\Repositories\Contracts\DealRepository;

/**
 * Class DealFinder
 * @package Modules\Form\Services\Bitrix
 * @property Collection $deals
 * @property DealRepository $repository
 */
class DealFinder
{
    // инициализируем пустой массив для сделок
    public $deals = [];
    private $repository;

    public function __construct(DealRepository $repository)
    {
        $this->deals = collect($this->deals);
        $this->repository = $repository;
    }

    /**
     * ищем сделки по полю LEAD_ID
     * @param array $leadIds
     * @return $this
     */
    public function byLeadIds(array $leadIds = []): self
    {
        if ($leadIds) {
            $deals = $this->repository->getDealsByLeads($leadIds);
            $this->deals = $this->deals->merge($deals);
        }

        return $this;
    }

    /**
     * ищем сделки по полю CONTACT_ID
     * @param array $contactIds
     * @return $this
     */
    public function byContactIds(array $contactIds = []): self
    {
        if ($contactIds) {
            $deals = $this->repository->getDealsByContacts($contactIds);
            $this->deals = $this->deals->merge($deals);
        }

        return $this;
    }

    /**
     * ищем сделки по полю Comment
     * @param string|null $phone
     * @param string|null $email
     * @return $this
     */
    public function byComments(?string $phone = null, ?string $email = null): self
    {
        $params = [];

        if (!is_null($email)) {
            $params[] = $email;
        }

        if (!is_null($phone)) {
            $params = array_merge($params, $this->findAllPhoneVariants($phone));
        }

        $deals = $this->repository->getDealsByComment($params);
        $this->deals = $this->deals->merge($deals);

        return $this;
    }

    private function findAllPhoneVariants($phone = null): array
    {
        if (!$phone) return [];

        return [$phone, "+7{$phone}", "7{$phone}", "8{$phone}"];
    }
}
