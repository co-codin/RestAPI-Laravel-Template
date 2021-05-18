<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Models\CanonicalEntity;
use Modules\Seo\Repositories\CanonicalRepository;

/**
 * Class CanonicalController
 * @package Modules\Seo\Http\Controllers
 */
class CanonicalController extends Controller
{
    public function __construct(
        private CanonicalRepository $repository
    ) {}

    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $canonical = $this->repository->jsonPaginate();

        return CanonicalResource::collection($canonical);
    }

    /**
     * Show the specified resource.
     * @param CanonicalEntity $canonical
     * @return CanonicalResource
     */
    public function show(CanonicalEntity $canonical): CanonicalResource
    {
        return new CanonicalResource($canonical);
    }
}
