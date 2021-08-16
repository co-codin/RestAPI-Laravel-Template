<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Vacancy\Http\Resources\VacancyResource;
use Modules\Vacancy\Repositories\VacancyRepository;

class VacancyController extends Controller
{
    public function __construct(
        protected VacancyRepository $vacancyRepository
    ) {}

    public function index()
    {
        $vacancies = $this->vacancyRepository->jsonPaginate();

        return VacancyResource::collection($vacancies);
    }

    public function show(int $vacancy)
    {
        $vacancy = $this->vacancyRepository->find($vacancy);

        return new VacancyResource($vacancy);
    }
}
