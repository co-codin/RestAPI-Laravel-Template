<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Models\Canonical;
use Modules\Seo\Repositories\CanonicalRepository;

class CanonicalController extends Controller
{
    public function __construct(
        protected CanonicalRepository $canonicalRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Canonical::class);

        $canonicals = $this->canonicalRepository->jsonPaginate();

        return CanonicalResource::collection($canonicals);
    }

    public function show(int $canonical)
    {
        $canonical = $this->canonicalRepository->find($canonical);

        $this->authorize('view', $canonical);

        return new CanonicalResource($canonical);
    }
}
