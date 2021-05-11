<?php


namespace App\Dto;



use Illuminate\Support\Collection as SupportCollection;

abstract class DtoCollection extends SupportCollection
{
    /**
     * @param string ...$keys
     *
     * @return static
     */
    public function except(string ...$keys): self
    {
        $dataTransferObjects = clone $this;

        foreach ($dataTransferObjects as $key => $dto) {
            $dataTransferObjects[$key] = $dto->except(...$keys);
        }

        return $dataTransferObjects;
    }
}
