<?php

namespace Modules\Client\Repositories;

use App\Repositories\BaseRepository;
use Modules\Client\Models\ClientCart;

class ClientCartRepository extends BaseRepository
{
    public function model()
    {
        return ClientCart::class;
    }
}
