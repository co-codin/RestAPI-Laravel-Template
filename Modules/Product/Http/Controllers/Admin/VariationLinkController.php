<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Modules\Product\Dto\VariationLinkDto;
use Modules\Product\Dto\VariationLinkDtoCollection;
use Modules\Product\Http\Requests\Admin\VariationLinkRequest;
use Modules\Product\Http\Resources\VariationLinkResource;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Repositories\VariationLinkRepository;
use Modules\Product\Services\VariationLinkStorage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class VariationLinkController extends Controller
{
    public function __construct(
        private VariationLinkRepository $repository,
        private VariationLinkStorage $storage
    ) {}

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function store(VariationLinkRequest $request): AnonymousResourceCollection
    {
        $productVariation = ProductVariation::whereId($request->validated()['product_variation_id'])->first();

        $variationLinks = $this->storage->store(
            $productVariation,
            VariationLinkDtoCollection::create($request->validated()['links'])
        );

        return VariationLinkResource::collection($variationLinks);
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function update(
        VariationLinkRequest $request,
        int $variationLinkId
    ): VariationLinkResource
    {
        $variationLink = $this->storage->update(
            $this->repository->find($variationLinkId),
            VariationLinkDto::fromFormRequest($request)
        );

        return new VariationLinkResource($variationLink);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $variationLinkId): Response
    {
        $this->storage->delete(
            $this->repository->find($variationLinkId)
        );

        return \response()->noContent();
    }
}
