<?php

namespace Modules\Vacancy\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Vacancy\Dto\VacancyDto;
use Modules\Vacancy\Http\Requests\VacancyCreateRequest;
use Modules\Vacancy\Http\Requests\VacancyUpdateRequest;
use Modules\Vacancy\Http\Resources\VacancyResource;
use Modules\Vacancy\Models\Vacancy;
use Modules\Vacancy\Repositories\VacancyRepository;
use Modules\Vacancy\Services\VacancyStorage;

class VacancyController extends Controller
{
    public function __construct(
        protected VacancyStorage $vacancyStorage,
        protected VacancyRepository $vacancyRepository
    ) {
    }

    public function store(VacancyCreateRequest $request)
    {
        $this->authorize('create', Vacancy::class);

        $vacancy = $this->vacancyStorage->store(VacancyDto::fromFormRequest($request));

        return new VacancyResource($vacancy);
    }

    public function update(int $vacancy, VacancyUpdateRequest $request)
    {
        $vacancy = $this->vacancyRepository->find($vacancy);

        $this->authorize('update', $vacancy);

        $vacancy = $this->vacancyStorage->update($vacancy, VacancyDto::fromFormRequest($request));

        return new VacancyResource($vacancy);
    }

    public function destroy(int $vacancy)
    {
        $vacancy = $this->vacancyRepository->find($vacancy);

        $this->authorize('delete', $vacancy);

        $this->vacancyStorage->delete($vacancy);

        return response()->noContent();
    }
}
