<?php

namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Customer\Dto\CustomerReviewDto;
use Modules\Customer\Http\Requests\Admin\CustomerReviewCreateRequest;
use Modules\Customer\Http\Requests\Admin\CustomerReviewUpdateRequest;
use Modules\Customer\Http\Resources\CustomerReviewResource;
use Modules\Customer\Models\CustomerReview;
use Modules\Customer\Services\Admin\CustomerReviewStorage;

class CustomerReviewController extends Controller
{
    public function __construct(
        protected CustomerReviewStorage $storage
    ) {
        $this->authorizeResource(CustomerReview::class, 'customer_review');
    }

    public function store(CustomerReviewCreateRequest $request): CustomerReviewResource
    {
        $customerReview = $this->storage->store(
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customerReview);
    }

    public function update(CustomerReviewUpdateRequest $request, CustomerReview $customer_review): CustomerReviewResource
    {
        $this->storage->update(
            $customer_review,
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customer_review);
    }

    public function destroy(CustomerReview $customer_review): Response
    {
        $this->storage->delete($customer_review);

        return response()->noContent();
    }
}
