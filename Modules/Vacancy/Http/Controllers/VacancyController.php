<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Vacancy\Http\Resources\VacancyResource;
use Modules\Vacancy\Models\Vacancy;
use Modules\Vacancy\Repositories\VacancyRepository;

class VacancyController extends Controller
{
    public function __construct(
        protected VacancyRepository $vacancyRepository
    ) {
        $this->authorizeResource(Vacancy::class, 'vacancy');
    }

    public function index()
    {
        $vacancies = $this->vacancyRepository->jsonPaginate();

        return VacancyResource::collection($vacancies);
    }

    public function show(Vacancy $vacancy)
    {
        return new VacancyResource($vacancy);
    }
}
