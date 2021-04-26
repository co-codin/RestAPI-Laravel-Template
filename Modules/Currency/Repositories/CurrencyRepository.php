<?php

namespace Modules\Currency\Repositories;

use App\Repositories\BaseRepository;
use Modules\Currency\Models\Currency;
use Modules\Currency\Repositories\Criteria\CurrencyRequestCriteria;

class CurrencyRepository extends BaseRepository
{
    public function model()
    {
        return Currency::class;
    }

    public function boot()
    {
        $this->pushCriteria(CurrencyRequestCriteria::class);
    }
}
