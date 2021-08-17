<?php


namespace Modules\Export\Services;


use Modules\Export\Dto\ExportDto;
use Modules\Export\Models\Export;

class ExportStorage
{
    public function store(ExportDto $exportDto)
    {
        $attributes = $exportDto->toArray();

        $attributes['assigned_by_id'] = $exportDto->assigned_by_id ?? auth('custom-token')->id();

        return Export::query()->create($attributes);
    }

    public function update(Export $export, ExportDto $exportDto)
    {
        $attributes = $exportDto->toArray();

        $attributes['assigned_by_id'] = $exportDto->assigned_by_id ?? null;

        if (!$export->update($attributes)) {
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
