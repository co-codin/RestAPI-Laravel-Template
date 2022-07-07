<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Vacancy\Http\Resources\VacancyPageResource;
use Modules\Vacancy\Repositories\VacancyRepository;

class VacancyPageController extends Controller
{
    public function __construct(
        protected VacancyRepository $vacancyRepository
    ) {
        $this->vacancyRepository->resetCriteria();
    }

    public function index()
    {
        $vacancies = $this->vacancyRepository
            ->scopeQuery(function ($query) {
                return $query->addSelect('id', 'name', 'slug', 'short_description', 'experience', 'timetable', 'occupation');
            })
            ->orderBy('id', 'desc')
            ->findWhere([
                'status' => Status::ACTIVE,
            ])
            ->all();

        return VacancyPageResource::collection($vacancies);
    }

    public function show(string $vacancy)
    {
        $vacancy = $this->vacancyRepository
            ->scopeQuery(function ($query) {
                return $query->addSelect(
                    'id', 'name', 'slug', 'short_description', 'experience',
                    'timetable', 'occupation', 'duty', 'requirement', 'condition'
                );
            })
            ->findByField('slug', $vacancy)
            ->first();

        return new VacancyPageResource($vacancy);
    }
}
