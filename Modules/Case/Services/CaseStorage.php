<?php


namespace Modules\Case\Services;


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

        $case = CaseModel::query()->create($attributes);

        return $case;
    }

    public function update(CaseModel $caseModel, CaseDto $caseDto)
    {
        $attributes = $caseDto->toArray();

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
