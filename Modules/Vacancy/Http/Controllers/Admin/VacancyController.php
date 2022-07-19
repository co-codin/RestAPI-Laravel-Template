<?php

namespace Modules\Vacancy\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Vacancy\Dto\VacancyDto;
use Modules\Vacancy\Http\Requests\VacancyCreateRequest;
use Modules\Vacancy\Http\Requests\VacancyUpdateRequest;
use Modules\Vacancy\Http\Resources\VacancyResource;
use Modules\Vacancy\Models\Vacancy;
use Modules\Vacancy\Services\VacancyStorage;

class VacancyController extends Controller
{
    public function __construct(
        protected VacancyStorage $vacancyStorage
    ) {
        $this->authorizeResource(Vacancy::class, 'vacancy');
    }

    public function store(VacancyCreateRequest $request)
    {
        $vacancy = $this->vacancyStorage->store(VacancyDto::fromFormRequest($request));

        return new VacancyResource($vacancy);
    }

    public function update(Vacancy $vacancy, VacancyUpdateRequest $request)
    {
        $vacancy = $this->vacancyStorage->update($vacancy, VacancyDto::fromFormRequest($request));

        return new VacancyResource($vacancy);
    }

    public function destroy(Vacancy $vacancy)
    {
        $this->vacancyStorage->delete($vacancy);

        return response()->noContent();
    }
}
