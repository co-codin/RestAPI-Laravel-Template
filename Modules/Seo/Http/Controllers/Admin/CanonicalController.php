<?php

namespace Modules\Seo\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Seo\Dto\CanonicalDto;
use Modules\Seo\Http\Requests\Admin\CanonicalUpdateRequest;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Http\Requests\Admin\CanonicalCreateRequest;
use Modules\Seo\Repositories\CanonicalRepository;
use Modules\Seo\Services\Admin\CanonicalStorage;

/**
 * Class CanonicalController
 * @package Modules\Seo\Http\Controllers\Admin
 */
class CanonicalController extends Controller
{
    public function __construct(
        private CanonicalRepository $repository,
        private CanonicalStorage $storage
    ) {}

    /**
     * Store a newly created resource in storage.
     * @param CanonicalCreateRequest $request
     * @return CanonicalResource
     * @throws \Exception
     */
    public function store(CanonicalCreateRequest $request): CanonicalResource
    {
        $canonicalDto = CanonicalDto::fromFormRequest($request);

        if (!$canonicalDto->assigned_by_id) {
            $canonicalDto->assigned_by_id = auth('api')->id();
        }

        $canonical = $this->storage->store($canonicalDto);

        return new CanonicalResource($canonical);
    }

    /**
     * Update the specified resource in storage.
     * @param CanonicalUpdateRequest $request
     * @param int $id
     * @return CanonicalResource
     * @throws \Exception
     */
    public function update(CanonicalUpdateRequest $request, int $id): CanonicalResource
    {
        $canonical = $this->repository->find($id);

        $canonical = $this->storage->update(
            $canonical,
            CanonicalDto::create($request->validated())->only(...$request->keys())
        );

        return new CanonicalResource($canonical);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy(int $id): Response
    {
        $canonical = $this->repository->find($id);
        $this->storage->delete($canonical);

        return response()->noContent();
    }
}
