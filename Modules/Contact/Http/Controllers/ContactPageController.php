<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Contact\Http\Resources\ContactPageResource;
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
        $contacts = $this->contactRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'first_name', 'last_name', 'job_position', 'email', 'phone', 'image')
                    ;
            })
            ->orderBy('position', 'asc')
            ->findWhere([
                'is_enabled' => true,
            ])
            ->all();

        return ContactPageResource::collection($contacts);
    }
}
