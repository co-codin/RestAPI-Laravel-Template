<?php


namespace Modules\Achievement\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Achievement\Http\Resources\AchievementResource;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\AchievementRepository;

class AchievementController extends Controller
{
    public function __construct(
        protected AchievementRepository $achievementRepository
    ) {
    }

    public function index()
    {
        $this->authorize('viewAny', Achievement::class);

        $achievements = $this->achievementRepository->jsonPaginate();

        return AchievementResource::collection($achievements);
    }

    public function show(int $achievement)
    {
        $achievement = $this->achievementRepository->find($achievement);

        $this->authorize('view', $achievement);

        return new AchievementResource($achievement);
    }
}
