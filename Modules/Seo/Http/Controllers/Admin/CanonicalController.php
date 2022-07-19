<?php

namespace Modules\Seo\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Seo\Dto\CanonicalDto;
use Modules\Seo\Http\Requests\Admin\CanonicalUpdateRequest;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Http\Requests\Admin\CanonicalCreateRequest;
use Modules\Seo\Models\Canonical;
use Modules\Seo\Services\Admin\CanonicalStorage;

class CanonicalController extends Controller
{
    public function __construct(
        protected CanonicalStorage $canonicalStorage
    ) {
        $this->authorizeResource(Canonical::class, 'canonical');
    }

    public function store(CanonicalCreateRequest $request): CanonicalResource
    {
        $canonicalDto = CanonicalDto::fromFormRequest($request);

        if (!$canonicalDto->assigned_by_id) {
            $canonicalDto->assigned_by_id = auth('sanctum')->id();
        }

        $canonical = $this->canonicalStorage->store($canonicalDto);

        return new CanonicalResource($canonical);
    }

    public function update(CanonicalUpdateRequest $request, Canonical $canonical): CanonicalResource
    {
        $canonical = $this->canonicalStorage->update(
            $canonical,
            CanonicalDto::create($request->validated())->only(...$request->keys())
        );

        return new CanonicalResource($canonical);
    }

    public function destroy(Canonical $canonical): Response
    {
        $this->canonicalStorage->delete($canonical);

        return response()->noContent();
    }
}
