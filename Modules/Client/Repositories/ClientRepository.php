<?php

namespace Modules\Client\Repositories;

use App\Repositories\BaseRepository;
use Modules\Client\Models\Client;

class ClientRepository extends BaseRepository
{
    public function model()
    {
        return Client::class;
    }
}
