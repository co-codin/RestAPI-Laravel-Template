<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\News\Repositories\NewsRepository;

class NewsPageController extends Controller
{
    public function __construct(
        protected NewsRepository $newsRepository
    ) {
        $this->newsRepository->resetCriteria();
    }

    public function index()
    {

    }

    public function show()
    {

    }
}
