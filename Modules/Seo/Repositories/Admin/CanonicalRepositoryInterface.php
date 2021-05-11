<?php


namespace Modules\Seo\Repositories\Admin;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CanonicalRepositoryInterface
 * @package Modules\Seo\Repositories\Admin
 */
interface CanonicalRepositoryInterface extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * @inheritDoc
     */
    public function model();
}
