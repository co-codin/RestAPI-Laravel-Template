<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Contact\Repositories\ContactRepository;

class ContactPageController extends Controller
{
    public function __construct(
        protected ContactRepository $contactRepository
    ) {
        $this->contactRepository->resetCriteria();
    }

    public function index()
    {
        
    }
}
