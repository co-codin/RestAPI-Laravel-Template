<?php

namespace Modules\Activity\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Activity\Http\Resources\ActivityResource;
use Modules\Activity\Models\Activity;
use Modules\Activity\Repositories\ActivityRepository;

class ActivityController extends Controller
{
    public function __construct(
        protected ActivityRepository $activityRepository
    ) {}

    public function index()
    {
//        $this->authorize('viewAny', Activity::class);

        $activities = $this->activityRepository->jsonPaginate();

        return ActivityResource::collection($activities);
    }
}
