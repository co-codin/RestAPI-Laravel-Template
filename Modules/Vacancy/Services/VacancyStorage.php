<?php


namespace Modules\Vacancy\Services;


use Modules\Vacancy\Dto\VacancyDto;
use Modules\Vacancy\Models\Vacancy;

class VacancyStorage
{
    public function store(VacancyDto $vacancyDto)
    {
        return Vacancy::query()->create($vacancyDto->toArray());
    }

    public function update(Vacancy $vacancy, VacancyDto $vacancyDto)
    {
        if (!$vacancy->update($vacancyDto->toArray())) {
            throw new \LogicException('can not update vacancy');
        }
        return $vacancy;
    }

    public function delete(Vacancy $vacancy)
    {
        if (!$vacancy->delete()) {
            throw new \LogicException('can not delete vacancy');
        }
    }
}
