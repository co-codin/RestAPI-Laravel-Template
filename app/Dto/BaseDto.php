<?php


namespace App\Dto;


use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Dto\CanonicalDto;
use Spatie\DataTransferObject\Arr;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class BaseDto extends DataTransferObject
{
    protected array $visibleKeys = [];

    /**
     * @param FormRequest $request
     * @return static
     * @throws UnknownProperties
     */
    public static function fromFormRequest(FormRequest $request): static
    {
        return (new static($validated = $request->validated()))
            ->visible(array_keys($validated));
    }


    /**
     * @param array $items
     * @return static
     * @throws UnknownProperties
     */
    public static function create(array $items): static
    {
        return new static($items);
    }

    /**
     * @param string|string[] ...$properties
     * @return BaseDto
     */
    public function toJson(...$properties): static
    {
        foreach ($properties as $property) {
            $this->{$property} = json_encode($this->{$property});
        }

        return $this;
    }

    public function visible(array $keys): self
    {
        $dataTransferObject = clone $this;

        $dataTransferObject->visibleKeys = [...$this->visibleKeys, ...$keys];

        return $dataTransferObject;
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        return $this->visibleKeys ? Arr::only($array, $this->visibleKeys) : $array;
    }
}
