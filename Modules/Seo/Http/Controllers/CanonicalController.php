<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Models\Canonical;
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
        $canonicals = $this->repository->jsonPaginate();

        return CanonicalResource::collection($canonicals);
    }

    /**
     * Show the specified resource.
     * @param Canonical $canonical
     * @return CanonicalResource
     */
    public function show(Canonical $canonical): CanonicalResource
    {
        return new CanonicalResource($canonical);
    }
}
