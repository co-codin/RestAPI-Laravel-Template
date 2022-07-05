<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Dto\ClientPayerDto;
use Modules\Client\Http\Requests\ClientPayerCreateRequest;
use Modules\Client\Http\Requests\ClientPayerUpdateRequest;
use Modules\Client\Http\Resources\ClientPayerResource;
use Modules\Client\Models\ClientPayer;
use Modules\Client\Repositories\ClientPayerRepository;
use Modules\Client\Repositories\ClientRepository;
use Modules\Client\Services\ClientPayerStorage;

class ClientPayerController extends Controller
{
    public function __construct(
        protected ClientPayerRepository $clientPayerRepository,
        protected ClientRepository $clientRepository,
        protected ClientPayerStorage $clientPayerStorage
    ){}

    public function index()
    {
        $clientPayers = $this->clientPayerRepository->findByField('client_id', auth('client-api')->id());

        return ClientPayerResource::collection($clientPayers);
    }

    public function store(ClientPayerCreateRequest $request)
    {
        $payer = $this->clientPayerStorage->store(auth('client-api')->user(), ClientPayerDto::fromFormRequest($request));

        return new ClientPayerResource($payer);
    }

    public function update(ClientPayerUpdateRequest $request, ClientPayer $payer)
    {
        $payer = $this->clientPayerStorage->update($payer, ClientPayerDto::fromFormRequest($request));

        return new ClientPayerResource($payer);
    }

    public function destroy(ClientPayer $payer): ?bool
    {
        abort_if($payer->client_id !== auth('client-api')->id(), 403);

        return $this->clientPayerStorage->destroy($payer);
    }
}
