<?php

namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Customer\Dto\CustomerReviewDto;
use Modules\Customer\Http\Requests\Admin\CustomerReviewCreateRequest;
use Modules\Customer\Http\Requests\Admin\CustomerReviewUpdateRequest;
use Modules\Customer\Http\Resources\CustomerReviewResource;
use Modules\Customer\Models\CustomerReview;
use Modules\Customer\Repositories\CustomerReviewRepository;
use Modules\Customer\Services\Admin\CustomerReviewStorage;

class CustomerReviewController extends Controller
{
    public function __construct(
        protected CustomerReviewStorage $storage,
        protected CustomerReviewRepository $customerReviewRepository
    ) {}

    public function store(CustomerReviewCreateRequest $request): CustomerReviewResource
    {
        $this->authorize('create', CustomerReview::class);

        $customerReview = $this->storage->store(
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customerReview);
    }

    public function update(CustomerReviewUpdateRequest $request, int $customer_review): CustomerReviewResource
    {
        $customer_review = $this->customerReviewRepository->find($customer_review);

        $this->authorize('update', $customer_review);

        $this->storage->update(
            $customer_review,
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customer_review);
    }

    public function destroy(int $customer_review): Response
    {
        $customer_review = $this->customerReviewRepository->find($customer_review);

        $this->authorize('delete', $customer_review);

        $this->storage->delete($customer_review);

        return response()->noContent();
    }
}
