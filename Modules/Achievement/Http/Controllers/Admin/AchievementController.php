<?php

namespace Modules\Achievement\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Http\Requests\AchievementPositionRequest;
use Modules\Achievement\Http\Requests\AchievementCreateRequest;
use Modules\Achievement\Http\Requests\AchievementUpdateRequest;
use Modules\Achievement\Repositories\AchievementRepository;
use Modules\Achievement\Services\AchievementPositionService;
use Modules\Achievement\Services\AchievementStorage;
use Modules\Achievement\Transformers\AchievementResource;

class AchievementController extends Controller
{
    public function __construct(
        protected AchievementStorage $achievementStorage,
        protected AchievementRepository $achievementRepository
    ){}

    public function index()
    {
        $achievements = $this->achievementRepository->jsonPaginate();

        return AchievementResource::collection($achievements);
    }

    public function show(int $achievement)
    {
        $achievementModel = $this->achievementRepository->find($achievement);

        return new AchievementResource($achievementModel);
    }

    public function store(AchievementCreateRequest $request)
    {
        $achievement = $this->achievementStorage->store(AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievement);
    }

    public function update(int $achievement, AchievementUpdateRequest $request)
    {
        $achievementModel = $this->achievementRepository->find($achievement);

        $achievementModel = $this->achievementStorage->update($achievementModel, AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievementModel);
    }

    public function destroy(int $achievement)
    {
        $achievementModel = $this->achievementRepository->find($achievement);

        $this->achievementStorage->delete($achievementModel);

        return response()->noContent();
    }

    public function modifyPosition(AchievementPositionRequest $request, AchievementPositionService $achievementPositionService)
    {
        $achievementPositionService->modifyPosition($request->get('positions'));

        return response()->noContent();
    }
}
