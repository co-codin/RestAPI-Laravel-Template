<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Http\Controllers\Controller;
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

    }

    public function show(string $vacancy)
    {

    }
}
