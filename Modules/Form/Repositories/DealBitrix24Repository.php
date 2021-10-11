<?php

namespace Modules\Form\Repositories;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Crm\Builder;
use Medeq\Bitrix24\Models\Crm\Deal\Deal;
use Medeq\Bitrix24\Models\Model;
use Modules\Form\Repositories\Contracts\DealRepository;

/**
 * Class DealBitrix24Repository
 * @package Medeq\CRM\Connections\Bitrix24\Repositories
 * @property Deal $model
 */
class DealBitrix24Repository implements DealRepository
{
    protected $model = Deal::class;

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return $this->model::query();
    }

    /**
     * @return Deal[]|Collection
     */
    public function findAll(): Collection
    {
        return $this->getQuery()->get();
    }

    /**
     * @param int $id
     * @return Deal|Model
     */
    public function findById(int $id): Model
    {
        return $this->getQuery()->find($id);
    }

    /**
     * @param array $leadIds
     * @return Deal[]|Collection
     */
    public function getDealsByLeads(array $leadIds): Collection
    {
        return $this->getQuery()
            ->select(['id', 'title', 'assigned_by_id', 'comments', 'uf_crm_1525856204', 'uf_crm_1525856795'])
            ->whereIn('lead_id', $leadIds)
            ->where('stage_id', '!=', ['won', 'lose', '1', '2', '3'])
            ->get();
    }

    /**
     * @param array $contactIds
     * @return Deal[]|Collection
     */
    public function getDealsByContacts(array $contactIds): Collection
    {
        return $this->getQuery()
            ->select(['id', 'title', 'assigned_by_id', 'comments', '', 'uf_crm_1525856204', 'uf_crm_1525856795'])
            ->whereIn('contact_id', $contactIds)
            ->where('stage_id', '!=', ['won', 'lose', '1', '2', '3'])
            ->get();
    }

    /**
     * @param array $params
     * @return Deal[]|Collection
     */
    public function getDealsByComment(array $params): Collection
    {
        return $this->getQuery()
            ->select(['id', 'title', 'assigned_by_id', 'comments', '', 'uf_crm_1525856204', 'uf_crm_1525856795'])
            ->orWhere(function(Builder $query) use ($params) {
                $query->where('comments', 'like', $params)
                    ->where('stage_id', '!=', ['won', 'lose', '1', '2', '3']);
            })
            ->get();
    }
}
