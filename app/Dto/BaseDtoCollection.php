<?php


namespace App\Dto;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection as SupportCollection;

abstract class BaseDtoCollection extends SupportCollection
{
    /**
     * method return single dto::class
     * @return string
     */
    abstract public function getSingleDtoClass(): string;

    /**
     * DtoCollection constructor.
     * @param BaseDto[]|array $items
     */
    public function __construct($items = [])
    {
        /** @var BaseDto $dto */
        $dto = $this->getSingleDtoClass();

        $items = array_map(
            static fn (BaseDto|array $data): BaseDto => $data instanceof $dto
                ? $data
                : $dto::create($data),
            $items
        );

        parent::__construct($items);
    }

    /**
     * @param array $items
     * @return static
     */
    public static function create(array $items = []): self
    {
        return new static($items);
    }

    /**
     * @param array|string ...$keys
     * @return static
     * @throws \Exception
     */
    public function exceptDtoKeys(array|string ...$keys): self
    {
        $keys = is_array($keys[0]) ? $keys[0] : $keys;

        /** @var BaseDto[]|$this $dtoCollection */
        $dtoCollection = clone $this;

        foreach ($dtoCollection as $key => $dto) {
            $dtoCollection[$key] = $dto->except(...$keys);
        }

        return $dtoCollection;
    }

    public function toArray(): array
    {
        $itemArray = [];

        foreach ($this as $value) {
            $itemArray[] = $value instanceof Arrayable
                ? $value->toArray()
                : $value;
        }

        return $itemArray;
    }
}
