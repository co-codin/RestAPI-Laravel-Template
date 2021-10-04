<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class BaseRepository
 * @method jsonPaginate(int $maxResults = null, int $defaultSize = null)
 */
abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        }
        elseif ($this->model instanceof QueryBuilder) {
            $results = $this->model->get($columns);
        }
        else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }
}
