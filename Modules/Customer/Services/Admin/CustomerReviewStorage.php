<?php


namespace Modules\Customer\Services\Admin;


use Modules\Customer\Dto\CustomerReviewDto;
use Modules\Customer\Models\CustomerReview;

/**
 * Class CustomerReviewStorage
 * @package Modules\Customer\Services\Admin
 */
class CustomerReviewStorage
{
    /**
     * @param CustomerReviewDto $dto
     * @return CustomerReview
     * @throws \Exception
     */
    public function store(CustomerReviewDto $dto): CustomerReview
    {
        $customerReview = new CustomerReview($dto->toArray());

        if (!$customerReview->save()) {
            throw new \Exception('Не удалось сохранить отзыв клиента');
        }

        return $customerReview;
    }

    /**
     * @param CustomerReview $customerReview
     * @param CustomerReviewDto $dto
     * @return CustomerReview
     * @throws \Exception
     */
    public function update(CustomerReview $customerReview, CustomerReviewDto $dto): CustomerReview
    {
        if (!$customerReview->update($dto->toArray())) {
            throw new \Exception('Не удалось обновить отзыв клиента - id' . $customerReview->id);
        }

        return $customerReview;
    }

    /**
     * @param CustomerReview $customerReview
     * @return CustomerReview
     * @throws \Exception
     */
    public function delete(CustomerReview $customerReview): CustomerReview
    {
        if (!$customerReview->delete()) {
            throw new \Exception('Не удалось удалить отзыв клиента - id' . $customerReview->id);
        }

        return $customerReview;
    }
}
