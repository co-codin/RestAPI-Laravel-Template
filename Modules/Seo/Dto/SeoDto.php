<?php


namespace Modules\Seo\Dto;


use App\Dto\Dto;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Enums\SeoType;

/**
 * Class SeoDto
 * @package Modules\Seo\Dto\Admin
 */
class SeoDto extends Dto
{
    /**
     * @var int
     */
    public $is_enabled;

    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $h1;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string|null
     */
    public $canonical;

    public int $type = SeoType::Self;

    /**
     * @var string|array|null
     */
    public $meta_tags;

    /**
     * @var object|array|null
     */
    public $texts;

    /**
     * @param FormRequest $request
     * @return self
     */
    public static function fromFormRequest(FormRequest $request): self
    {
        $validated = $request->validated()['seo'];

        return static::create($validated);
    }

    /**
     * @param array $data
     * @return static
     */
    public static function create(array $data)
    {
        return new static([
            'is_enabled' => (int)$data['is_enabled'],
            'title' => $data['title'] ?? null,
            'h1' => $data['h1'] ?? null,
            'description' => $data['description'] ?? null,
            'canonical' => $data['canonical'] ?? null,
            'type' => $data['type'] ?? null,
            'meta_tags' => $data['meta_tags'] ?? null,
            'texts' => $data['texts'] ?? null,
        ]);
    }
}
