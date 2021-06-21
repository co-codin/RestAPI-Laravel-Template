<?php


namespace Modules\Export\Services;


use Modules\Export\Dto\ExportDto;
use Modules\Export\Models\Export;

class ExportStorage
{
    public function store(ExportDto $exportDto)
    {
        return Export::query()->create($exportDto->toArray());
    }

    public function update(Export $export, ExportDto $exportDto)
    {
        if (!$export->update($exportDto->toArray())) {
            throw new \LogicException('can not update export');
        }

        return $export;
    }

    public function delete(Export $export)
    {
        if (!$export->delete()) {
            throw new \LogicException('can not delete export');
        }
    }
}
