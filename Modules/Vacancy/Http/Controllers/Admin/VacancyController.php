<?php

namespace Modules\Vacancy\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Vacancy\Http\Requests\VacancyCreateRequest;
use Modules\Vacancy\Repositories\VacancyRepository;

class VacancyController extends Controller
{
    public function __construct(
        protected VacancyRepository $vacancyRepository
    ) {}

    public function store(VacancyCreateRequest $request)
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
