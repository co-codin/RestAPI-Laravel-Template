<?php

namespace App\Repositories;

use App\Repositories\Criteria\ActiveStatusCriteria;
use App\Repositories\Criteria\NoInactiveCriteria;

/**
 * Class BaseRepository
 * @method jsonPaginate()
 */
abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{

}
