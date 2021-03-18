<?php


namespace App\Dto;


use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Dto extends DataTransferObject
{
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
        return new static($request->validated());
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
     * @return Dto
     */
    public function toJson(...$properties)
    {
        foreach ($properties as $property) {
            $this->{$property} = json_encode($this->{$property});
        }

        return $this;
    }
}
