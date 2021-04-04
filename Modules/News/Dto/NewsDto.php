<?php


namespace Modules\News\Dto;


use App\Dto\Dto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NewsDto
 * @package Modules\News\Dto\Admin
 */
class NewsDto extends Dto
{
    public ?string $name;

    public ?string $short_description;

    public ?string $full_description;

    public ?int $status;

    public ?string $slug;

    public ?string $image;

    public ?bool $in_home;

    /**
     * @var int|null
     */
    public $views_num;

    /**
     * @var string
     */
    public $news_date;

    /**
     * @param FormRequest $request
     * @return self
     */
    public static function fromFormRequest(FormRequest $request): self
    {
        return new static($request->except(['seo', 'tags']));
    }
}
