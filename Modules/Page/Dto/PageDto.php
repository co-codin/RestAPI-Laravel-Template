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

        $validated['assigned_by_id'] = self::getAssignedById($request);

        return new static($validated);
    }

    protected static function getAssignedById(FormRequest $request)
    {
        return !empty($request->get('assigned_by_id')) ? $request->get('assigned_by_id') : ($request->isMethod('POST') ? auth('custom-token')->id() : null);
    }
}
