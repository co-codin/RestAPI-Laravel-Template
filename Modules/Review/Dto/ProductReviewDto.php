<?php

namespace Modules\Review\Dto;

use App\Dto\BaseDto;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductReviewDto extends BaseDto
{
    public ?int $client_id;

    public ?int $experience;

    public ?string $advantages;

    public ?string $disadvantages;

    public ?string $comment;

    public ?int $status;

    public ?int $is_confirmed;

    public ?array $ratings;

    public ?int $like;

    public ?int $dislike;

    /**
     * @param FormRequest $request
     * @return static
     * @throws UnknownProperties
     */
    public static function fromFormRequest(FormRequest $request): static
    {
        $validated = array_merge(
            ['client_id' => \Auth::user()->id],
            $request->validated()
        );

        return (new static($validated))
            ->visible(array_keys($validated));
    }
}
