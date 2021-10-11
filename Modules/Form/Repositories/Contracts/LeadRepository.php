<?php


namespace Modules\Form\Repositories\Contracts;


use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Crm\Lead\Lead;

/**
 * Interface LeadRepositoryInterface
 * @package Modules\Form\Repositories\Contracts
 *
 * @method Lead[]|Collection|null findAll()
 * @method Lead|null findById()
 */
interface LeadRepository extends BaseRepository
{

}
