<?php

namespace Modules\Faq\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Faq\Repositories\QuestionCategoryRepository;
use Modules\Faq\Services\QuestionCategoryStorage;

class QuestionCategoryController extends Controller
{
    public function __construct(
        protected QuestionCategoryRepository $questionCategoryRepository,
        protected QuestionCategoryStorage $questionCategoryStorage
    ) {}

    public function index()
    {

    }

    public function show()
    {

    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
