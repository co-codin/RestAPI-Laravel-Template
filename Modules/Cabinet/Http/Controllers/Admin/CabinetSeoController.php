<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Models\Cabinet;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class CabinetSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
    ) {}

    public function update(SeoUpdateRequest $request, Cabinet $cabinet)
    {
        $this->authorize('update', $cabinet);

        $seo = $this->seoStorage->update(
            $cabinet->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}
