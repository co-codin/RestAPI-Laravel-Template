<?php


namespace Modules\Seo\Dto;


use App\Dto\Dto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SeoRuleDto
 * @package Modules\Seo\Dto\Admin
 */
class SeoRuleDto extends Dto
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string|null
     */
    public $text;

    /**
     * @param FormRequest $request
     * @return self
     */
    public static function fromFormRequest(FormRequest $request): self
    {
        return new static($request->except('seo'));
    }
}
