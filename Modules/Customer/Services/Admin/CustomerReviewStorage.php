<?php


namespace Modules\Customer\Services\Admin;


use App\Services\File\FileUploader;
use App\Services\File\ImageUploader;
use Illuminate\Http\UploadedFile;
use Modules\Customer\Dto\CustomerReviewDto;
use Modules\Customer\Models\CustomerReview;

/**
 * Class CustomerReviewStorage
 * @package Modules\Customer\Services\Admin
 */
class CustomerReviewStorage
{
    public function __construct(
        private ImageUploader $imageUploader,
        private FileUploader $fileUploader
    ) {}

    /**
     * @param CustomerReviewDto $dto
     * @return CustomerReview
     * @throws \Exception
     */
    public function store(CustomerReviewDto $dto): CustomerReview
    {
        $attributes = $this->getPreparedAttributes($dto);
        $customerReview = new CustomerReview($attributes);

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
        $attributes = $this->getPreparedAttributes($dto);

        if (!$customerReview->update($attributes)) {
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

    /**
     * @param CustomerReviewDto $dto
     * @return array
     */
    private function getPreparedAttributes(CustomerReviewDto $dto): array
    {
        $attributes = $dto->toArray();

        if ($dto->logo && $dto->logo instanceof UploadedFile) {
            $attributes['logo'] = $this->imageUploader->upload($dto->logo);
        }

        if ($dto->review_file && $dto->review_file instanceof UploadedFile) {
            $attributes['review_file'] = $this->fileUploader->upload($dto->review_file);
        }

        return $attributes;
    }
}
