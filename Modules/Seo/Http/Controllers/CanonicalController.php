<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Models\CanonicalEntity;
use Modules\Seo\Repositories\Admin\CanonicalRepositoryInterface;
use Modules\Seo\Repositories\Admin\Criteria\CanonicalQueryBuilderCriteria;

/**
 * Class CanonicalController
 * @package Modules\Seo\Http\Controllers
 */
class CanonicalController extends Controller
{
    public function __construct(private CanonicalRepositoryInterface $repository)
    {
        $this->repository->pushCriteria(CanonicalQueryBuilderCriteria::class);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $canonical = $this->repository->paginate(
            \request()->get('limit') ?? 25
        );

        return CanonicalResource::collection($canonical);
    }

    /**
     * Show the specified resource.
     * @param CanonicalEntity $canonical
     * @return CanonicalResource
     */
    public function show(CanonicalEntity $canonical)
    {
        return new CanonicalResource($canonical);
    }
}
