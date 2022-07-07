<?php

namespace Modules\Publication\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Publication\Http\Resources\PublicationPageResource;
use Modules\Publication\Repositories\PublicationRepository;

class PublicationPageController extends Controller
{
    public function __construct(
        protected PublicationRepository $publicationRepository
    ) {
        $this->publicationRepository->resetCriteria();
    }

    public function index()
    {
        $brands = $this->publicationRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'source', 'logo', 'url', 'published_at')
                    ;
            })
            ->orderBy('published_at', 'desc')
            ->findWhere([
                'is_enabled' => true,
            ])
            ->all();

        return PublicationPageResource::collection($brands);
    }
}
