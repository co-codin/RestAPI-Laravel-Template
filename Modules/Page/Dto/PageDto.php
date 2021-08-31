<?php


namespace Modules\Page\Dto;


use App\Dto\BaseDto;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PageDto
 * @package Modules\Page\Dto\Admin
 */
class PageDto extends BaseDto
{
    public ?int $parent_id;

    public ?string $name;

    public ?string $slug;

    public ?string $full_description;

    /** @var mixed */
    public $status;

    public ?int $assigned_by_id;

    public static function fromFormRequest(FormRequest $request): static
    {
        $validated = $request->validated();

        $validated['assigned_by_id'] = !empty($validated['assigned_by_id']) ? $validated['assigned_by_id'] : auth('custom-token')->id();

        return new static($validated);
    }
}
