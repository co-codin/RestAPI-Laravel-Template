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

/**
 * Class CustomerReviewController
 * @package Modules\Customer\Http\Controllers\Admin
 */
class CustomerReviewController extends Controller
{
    public function __construct(
        private CustomerReviewRepository $repository,
        private CustomerReviewStorage $storage
    ) {}

    /**
     * Store a newly created resource in storage.
     * @param CustomerReviewCreateRequest $request
     * @return CustomerReviewResource
     * @throws \Exception
     */
    public function store(CustomerReviewCreateRequest $request): CustomerReviewResource
    {
        $customerReview = $this->storage->store(
            CustomerReviewDto::fromFormRequest($request)
        );

        return new CustomerReviewResource($customerReview);
    }

    /**
     * Update the specified resource in storage.
     * @param CustomerReviewUpdateRequest $request
     * @param int $id
     * @return CustomerReviewResource
     * @throws \Exception
     */
    public function update(CustomerReviewUpdateRequest $request, int $id): CustomerReviewResource
    {
        $customerReview = $this->repository->find($id);

        $this->storage->update(
            $customerReview,
            CustomerReviewDto::create($request->validated())->only(...$request->keys())
        );

        return new CustomerReviewResource($customerReview);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy(int $id): Response
    {
        $customerReview = $this->repository->find($id);
        $this->storage->delete($customerReview);

        return response()->noContent();
    }
}
