<?php

namespace Modules\Cabinet\Services;

use App\Services\File\ImageUploader;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Models\Cabinet;

class CabinetStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(CabinetDto $cabinetDto)
    {
        $attributes = $cabinetDto->toArray();

        if ($cabinetDto->image) {
            $attributes['image'] = $this->imageUploader->upload($cabinetDto->image);
        }

        return Cabinet::query()->create($attributes);
    }

    public function update(Cabinet $cabinet, CabinetDto $cabinetDto)
    {
        $attributes = $cabinetDto->toArray();

        if ($cabinetDto->is_image_changed) {
            $attributes['image'] = $this->imageUploader->upload($cabinetDto->image);
        }

        if ($cabinetDto->categories) {
            foreach ($cabinetDto->categories as $category) {
                $cabinet->categories()->attach($category->id, [
                    'name' => $category->name,
                    'count' => $category->count,
                    'price' => $category->price ?: null,
                    'position' => $category->position ?: null,
                ]);
            }
        }

        if ($cabinetDto->documents) {
            foreach ($cabinetDto->documents as $document) {
                $cabinet->documents()->create([
                    'group_name' => $document->group_name,
                    'name' => $document->name,
                    'type' => $document->type,
                    'file' => $document->file ?? null,
                ]);
            }
        }

        if (!$cabinet->update($attributes)) {
            throw new \LogicException('can not update cabinet');
        }

        return $cabinet;
    }

    public function destroy(Cabinet $cabinet)
    {
        if (!$cabinet->delete()) {
            throw new \LogicException('can not delete cabinet');
        }
    }
}
