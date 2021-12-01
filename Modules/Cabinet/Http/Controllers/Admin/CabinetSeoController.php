<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class CabinetSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected CabinetRepository $cabinetRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $cabinet)
    {
        $cabinet = $this->cabinetRepository->skipCriteria()->find($cabinet);

        $seo = $this->seoStorage->update(
            $cabinet->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}
