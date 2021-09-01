<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Geo\Http\Resources\SoldProductResource;
use Modules\Geo\Repositories\SoldProductRepository;

class SoldProductController extends Controller
{
    public function __construct(
        protected SoldProductRepository $soldProductRepository
    ){}

    public function index()
    {
        $soldProducts = $this->soldProductRepository->jsonPaginate();

        return SoldProductResource::collection($soldProducts);
    }

    public function show(int $sold_product)
    {
        $soldProduct = $this->soldProductRepository->find($sold_product);

        return new SoldProductResource($soldProduct);
    }
}
