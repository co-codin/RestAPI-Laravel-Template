<?php

namespace Modules\Vacancy\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Vacancy\Dto\VacancyDto;
use Modules\Vacancy\Http\Requests\VacancyCreateRequest;
use Modules\Vacancy\Http\Requests\VacancyUpdateRequest;
use Modules\Vacancy\Http\Resources\VacancyResource;
use Modules\Vacancy\Repositories\VacancyRepository;
use Modules\Vacancy\Services\VacancyStorage;

class VacancyController extends Controller
{
    public function __construct(
        protected VacancyRepository $vacancyRepository,
        protected VacancyStorage $vacancyStorage
    ) {}

    public function store(VacancyCreateRequest $request)
    {
        $vacancy = $this->vacancyStorage->store(VacancyDto::fromFormRequest($request));

        return new VacancyResource($vacancy);
    }

    public function update(int $vacancy, VacancyUpdateRequest $request)
    {
        $vacancyModel = $this->vacancyRepository->find($vacancy);

        $vacancyModel = $this->vacancyStorage->update($vacancyModel, VacancyDto::fromFormRequest($request));

        return new VacancyResource($vacancyModel);
    }

    public function destroy(int $vacancy)
    {
        $vacancyModel = $this->vacancyRepository->find($vacancy);

        $this->vacancyStorage->delete($vacancyModel);

        return response()->noContent();
    }
}
