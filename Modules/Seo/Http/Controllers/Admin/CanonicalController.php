<?php

namespace Modules\Seo\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Seo\Dto\Admin\CanonicalDto;
use Modules\Seo\Http\Resources\CanonicalResource;
use Modules\Seo\Http\Requests\Admin\CanonicalRequest;
use Modules\Seo\Repositories\Admin\CanonicalRepositoryInterface;
use Modules\Seo\Services\Admin\CanonicalStorage;

/**
 * Class CanonicalController
 * @package Modules\Seo\Http\Controllers\Admin
 */
class CanonicalController extends Controller
{
    public function __construct(
        private CanonicalRepositoryInterface $repository,
        private CanonicalStorage $storage
    )
    {}

    /**
     * Store a newly created resource in storage.
     * @param CanonicalRequest $request
     * @return CanonicalResource
     * @throws \Exception
     */
    public function store(CanonicalRequest $request)
    {
        $canonical = $this->storage->store(
            CanonicalDto::fromFormRequest($request)
        );

        return new CanonicalResource($canonical);
    }

    /**
     * Update the specified resource in storage.
     * @param CanonicalRequest $request
     * @param int $id
     * @return CanonicalResource
     * @throws \Exception
     */
    public function update(CanonicalRequest $request, int $id)
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
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $canonical = $this->repository->find($id);
        $this->storage->delete($canonical);

        return response()->noContent();
    }
}
