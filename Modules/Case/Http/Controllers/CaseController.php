<?php

namespace Modules\Case\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Case\Repositories\CaseRepository;

class CaseController extends Controller
{
    public function __construct(
        protected CaseRepository $caseRepository
    ) {}

    public function index()
    {

    }

    public function show()
    {

    }
}
