<?php

namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Customer\Dto\CustomerReviewDto;
use Modules\Customer\Http\Requests\Admin\CustomerReviewCreateRequest;
use Modules\Customer\Http\Requests\Admin\CustomerReviewUpdateRequest;
use Modules\Customer\Http\Resources\CustomerReviewResource;
use Modules\Customer\Repositories\CustomerReviewRepository;
use Modules\Customer\Services\Admin\CustomerReviewStorage;

class CustomerReviewController extends Controller
{
    public function __construct(
        private CustomerReviewRepository $repository,
        private CustomerReviewStorage $storage
    ) {}

    public function store(CustomerReviewCreateRequest $request): CustomerReviewResource
    {
        $customerReview = $this->storage->store(
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customerReview);
    }

    public function update(CustomerReviewUpdateRequest $request, int $id): CustomerReviewResource
    {
        $customerReview = $this->repository->find($id);

        $this->storage->update(
            $customerReview,
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customerReview);
    }

    public function destroy(int $id): Response
    {
        $customerReview = $this->repository->find($id);
        $this->storage->delete($customerReview);

        return response()->noContent();
    }
}
