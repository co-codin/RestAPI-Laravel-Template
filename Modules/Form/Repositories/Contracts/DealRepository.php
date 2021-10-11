<?php

namespace Modules\Form\Repositories\Contracts;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Crm\Deal\Deal;

/**
 * Interface DealRepositoryInterface
 * @package Modules\Form\Repositories\Contracts
 */
interface DealRepository extends BaseRepository
{
    /**
     * @param array $leadIds
     * @return Deal[]|Collection
     */
    public function getDealsByLeads(array $leadIds): Collection;

    /**
     * @param array $contactIds
     * @return Deal[]|Collection
     */
    public function getDealsByContacts(array $contactIds): Collection;

    /**
     * @param array $params
     * @return Deal[]|Collection
     */
    public function getDealsByComment(array $params): Collection;
}
