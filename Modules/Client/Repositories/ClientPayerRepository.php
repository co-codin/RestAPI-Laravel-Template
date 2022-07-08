<?php

namespace Modules\Client\Repositories;

use App\Repositories\BaseRepository;
use Modules\Client\Models\ClientPayer;

class ClientPayerRepository extends BaseRepository
{
    public function model()
    {
        return ClientPayer::class;
    }
}
