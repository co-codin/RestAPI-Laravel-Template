<?php

namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Resources\VariationLinkResource;
use Modules\Product\Repositories\VariationLinkRepository;

class VariationLinkController extends Controller
{
    public function __construct(
        private VariationLinkRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return VariationLinkResource::collection(
            $this->repository->jsonPaginate()
        );
    }

    public function show(int $variationLinkId): VariationLinkResource
    {
        return new VariationLinkResource(
            $this->repository->find($variationLinkId)
        );
    }
}
