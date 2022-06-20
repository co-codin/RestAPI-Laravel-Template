<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Http\Requests\ClientCartRequest;
use Modules\Client\Http\Resources\ClientCartResource;
use Modules\Client\Repositories\ClientCartRepository;
use Modules\Client\Services\ClientCartStorage;

class ClientCartController extends Controller
{
    public function __construct(
        protected ClientCartRepository $clientCartRepository,
        protected ClientCartStorage $clientCartStorage
    ){}

    public function index()
    {
        return ClientCartResource::collection(
            $this->clientCartRepository->all()
        );
    }

    public function store(ClientCartRequest $request)
    {
        $productVariationId = $request->validated()['product_variation_id'];
        $count = $request->validated()['count'];

        $clientCart = $this->clientCartStorage->store(
            $productVariationId,
            $count
        );

        return new ClientCartResource($clientCart);
    }
}
