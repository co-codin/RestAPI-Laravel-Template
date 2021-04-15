<?php


namespace Modules\Achievement\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Achievement\Http\Resources\AchievementResource;
use Modules\Achievement\Repositories\AchievementRepository;

class AchievementController extends Controller
{
    public function __construct(
        protected AchievementRepository $achievementRepository
    ) {}

    public function index()
    {
        $achievements = $this->achievementRepository->jsonPaginate();

        return AchievementResource::collection($achievements);
    }

    public function show(int $achievement)
    {
        $achievement = $this->achievementRepository->find($achievement);

        return new AchievementResource($achievement);
    }
}
