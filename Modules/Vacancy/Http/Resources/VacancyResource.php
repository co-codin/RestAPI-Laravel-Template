<?php


namespace Modules\Vacancy\Http\Resources;


use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Vacancy\Models\Vacancy;

/**
 * Class VacancyResource
 * @package Modules\Vacancy\Http\Resources
 * @mixin Vacancy
 */
class VacancyResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested(
                'status',
                Status::fromValue($this->status)->toArray()
            ),
        ]);
    }
}
