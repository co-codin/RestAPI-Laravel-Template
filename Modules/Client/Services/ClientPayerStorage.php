<?php

namespace Modules\Client\Services;

use Modules\Client\Dto\ClientPayerDto;
use Modules\Client\Models\Client;
use Modules\Client\Models\ClientPayer;

class ClientPayerStorage
{
    public function store(Client $client, ClientPayerDto $dto)
    {
        return $client->clientPayers()->create($dto->toArray());
    }

    public function update(ClientPayer $payer, ClientPayerDto $dto)
    {
        if (!$payer->update($dto->toArray())) {
            throw new \LogicException("Cant update payer");
        }

        return $payer;
    }

    public function destroy(ClientPayer $clientPayer): ?bool
    {
        return $clientPayer->delete();
    }
}
