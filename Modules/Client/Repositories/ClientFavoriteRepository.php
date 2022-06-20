<?php

namespace Modules\Client\Repositories;

use App\Repositories\BaseRepository;
use Modules\Client\Models\ClientFavorite;

class ClientFavoriteRepository extends BaseRepository
{
    public function model()
    {
        return ClientFavorite::class;
    }
}
