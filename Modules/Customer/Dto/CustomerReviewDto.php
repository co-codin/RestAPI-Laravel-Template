<?php


namespace Modules\Customer\Dto;


use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;
use Modules\Customer\Enums\CustomerType;

/**
 * Class CustomerReviewDto
 * @package Modules\Customer\Dto
 */
class CustomerReviewDto extends BaseDto
{
    public ?string $position;

    public ?string $company_name;

    public ?int $product_id;

    public ?string $author;

    public int $type = CustomerType::PrivatePerson;

    public ?string $video;

    public $is_review_file_changed;

    public UploadedFile|string|null $review_file;

    public bool $is_in_home = false;

    public ?string $comment;

    public $is_logo_changed;

    public UploadedFile|string|null $logo;
}
