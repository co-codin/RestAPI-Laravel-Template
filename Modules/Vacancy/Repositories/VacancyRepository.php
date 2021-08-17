<?php


namespace Modules\Vacancy\Repositories;


use App\Repositories\BaseRepository;
use Modules\Vacancy\Models\Vacancy;
use Modules\Vacancy\Repositories\Criteria\VacancyRequestCriteria;

class VacancyRepository extends BaseRepository
{
    public function model()
    {
        return Vacancy::class;
    }

    public function boot()
    {
        $this->pushCriteria(VacancyRequestCriteria::class);
    }
}
