<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Customer\Http\Resources\CustomerReviewResource;
use Modules\Customer\Models\CustomerReview;
use Modules\Customer\Repositories\CustomerReviewRepository;

class CustomerReviewController extends Controller
{
    public function __construct(
        private CustomerReviewRepository $repository
    ) {}

    public function index()
    {
        $customerReviews = $this->repository->jsonPaginate();

        return CustomerReviewResource::collection($customerReviews);
    }

    public function show(CustomerReview $customerReview)
    {
        return new CustomerReviewResource($customerReview);
    }
}
