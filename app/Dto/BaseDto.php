<?php


namespace App\Dto;


use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Arr;
use Spatie\DataTransferObject\DataTransferObject;

abstract class BaseDto extends DataTransferObject
{
    protected array $visibleKeys = [];

    /**
     * Dto constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $class = get_called_class();
        $properties = get_class_vars($class);

        foreach ($parameters as $key => $parameter) {
            if (!array_key_exists($key, $properties)) {
                unset($parameters[$key]);
            }
        }

        parent::__construct($parameters);
    }

    /**
     * @param FormRequest $request
     * @return static
     */
    public static function fromFormRequest(FormRequest $request)
    {
        return (new static($request->validated()))
            ->visible($request->keys());
    }

    /**
     * @param array $items
     * @return static
     */
    public static function create(array $items)
    {
        return new static($items);
    }

    /**
     * @param string|string[] ...$properties
     * @return BaseDto
     */
    public function toJson(...$properties)
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
