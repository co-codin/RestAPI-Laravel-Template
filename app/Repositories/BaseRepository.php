<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @method jsonPaginate()
 */
class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    public function model()
    {
        return Model::class;
    }
}
