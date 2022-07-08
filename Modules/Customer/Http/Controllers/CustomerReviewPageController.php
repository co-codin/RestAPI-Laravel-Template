<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Customer\Http\Resources\CustomerReviewPageResource;
use Modules\Customer\Repositories\CustomerReviewRepository;

class CustomerReviewPageController extends Controller
{
    public function __construct(
        protected CustomerReviewRepository $customerReviewRepository
    ) {
        $this->customerReviewRepository->resetCriteria();
    }

    public function index()
    {
        $brands = $this->customerReviewRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect(
                        'id', 'company_name', 'position', 'video', 'logo',
                        'review_file', 'comment', 'author', 'type', 'product_id',
                    )
                    ->with(['product' => function ($query) {
                        $query->addSelect('id', 'name');
                    }])
                    ;
            })

            ->all();

        return CustomerReviewPageResource::collection($brands);
    }
}
