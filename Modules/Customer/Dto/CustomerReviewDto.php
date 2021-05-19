<?php


namespace Modules\Customer\Dto;


use App\Dto\BaseDto;

/**
 * Class CustomerReviewDto
 * @package Modules\Customer\Dto
 */
class CustomerReviewDto extends BaseDto
{
    public string $post;
    public string $author;
    public int $type;
    public ?string $video;
    public ?string $review_file;
    public bool $is_home;
    public string $comment;
    public ?string $logo;
}
