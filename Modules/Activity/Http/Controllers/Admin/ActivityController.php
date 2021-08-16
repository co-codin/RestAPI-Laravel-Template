<?php

namespace Modules\Activity\Http\Controllers\Admin;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Activity\Http\Resources\ActivityResource;
use Modules\Activity\Repositories\ActivityRepository;

class ActivityController extends Controller
{
    public function __construct(
        private ActivityRepository $repository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $activities = $this->repository->jsonPaginate();

        return ActivityResource::collection($activities);
    }
}
