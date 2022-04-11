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

    }

    public function update(CaseModel $caseModel, CaseDto $caseDto)
    {

    }
}
