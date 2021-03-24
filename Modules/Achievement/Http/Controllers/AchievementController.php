<?php


namespace Modules\Achievement\Http\Controllers;


use App\Repositories\Criteria\IsEnabledCriteria;
use Illuminate\Routing\Controller;
use Modules\Achievement\Repositories\AchievementRepository;
use Modules\Achievement\Transformers\AchievementResource;

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
}
