<?php

namespace Modules\Form\Repositories;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Builder;
use Medeq\Bitrix24\Models\Crm\Lead\Lead;
use Medeq\Bitrix24\Models\Model;
use Modules\Form\Repositories\Contracts\LeadRepository;

/**
 * Class LeadBitrix24Repository
 * @package Medeq\CRM\Connections\Bitrix24\Repositories
 * @property Lead $model
 */
class LeadBitrix24Repository implements LeadRepository
{
    protected $model = Lead::class;

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return $this->model::query();
    }

    /**
     * @return Lead[]|Collection
     */
    public function findAll(): Collection
    {
        return $this->getQuery()->get();
    }

    /**
     * @param int $id
     * @return Lead|Model
     */
    public function findById(int $id): Model
    {
        return $this->getQuery()->find($id);
    }
}
