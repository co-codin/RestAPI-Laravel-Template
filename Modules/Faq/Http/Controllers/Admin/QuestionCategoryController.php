<?php

namespace Modules\Faq\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Faq\Repositories\QuestionCategoryRepository;

class QuestionCategoryController extends Controller
{
    public function __construct(
        protected QuestionCategoryRepository $questionCategoryRepository
    ) {}

    public function index()
    {

    }

    public function show()
    {

    }
}
