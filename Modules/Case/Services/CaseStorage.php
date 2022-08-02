<?php


namespace Modules\Case\Services;


use Illuminate\Support\Arr;
use Modules\Case\Dto\CaseDto;
use Modules\Case\Models\CaseModel;
use Modules\Case\Repositories\CaseRepository;

class CaseStorage
{
    public function __construct(
        protected CaseRepository $caseRepository
    ) {}

    public function store(CaseDto $caseDto)
    {
        $attributes = $caseDto->toArray();

        return CaseModel::query()->create($attributes);
    }

    public function update(CaseModel $caseModel, CaseDto $caseDto)
    {
        $attributes = $caseDto->toArray();

        if ($caseDto->products) {
            $caseModel->products()
                ->sync(Arr::pluck($caseDto->products, 'id'));
        }

        if (!$caseModel->update($attributes)) {
            throw new \LogicException('can not update case');
        }

        return $caseModel;
    }

    public function delete(CaseModel $caseModel)
    {
        if (!$caseModel->delete()) {
            throw new \LogicException('can not delete case');
        }
    }
}
