<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Customer\Http\Resources\CustomerReviewResource;
use Modules\Customer\Models\CustomerReview;
use Modules\Customer\Repositories\CustomerReviewRepository;

class CustomerReviewController extends Controller
{
    public function __construct(
        private CustomerReviewRepository $repository
    ) {}

    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $customerReviews = $this->repository->jsonPaginate();

        return CustomerReviewResource::collection($customerReviews);
    }

    /**
     * Show the specified resource.
     * @param CustomerReview $customerReview
     * @return CustomerReviewResource
     */
    public function show(CustomerReview $customerReview): CustomerReviewResource
    {
        return new CustomerReviewResource($customerReview);
    }
}
