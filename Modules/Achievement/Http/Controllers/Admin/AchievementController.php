<?php

namespace Modules\Achievement\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Dto\AchievementPositionDto;
use Modules\Achievement\Http\Requests\AchievementPositionRequest;
use Modules\Achievement\Http\Requests\AchievementRequest;
use Modules\Achievement\Services\AchievementPositionService;
use Modules\Achievement\Services\AchievementStorage;
use Modules\Achievement\Transformers\AchievementResource;

class AchievementController extends Controller
{
    protected AchievementStorage $achievementStorage;
    protected AchievementPositionService $achievementPositionService;

    public function __construct(AchievementStorage $achievementStorage, AchievementPositionService $achievementPositionService)
    {
        $this->achievementStorage = $achievementStorage;
        $this->achievementPositionService = $achievementPositionService;
    }

    public function store(AchievementRequest $request)
    {
        $achievement = $this->achievementStorage->store(AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievement);
    }

    public function update(int $achievementId, AchievementRequest $request)
    {
        $achievement = $this->achievementStorage->update($achievementId, AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievement);
    }

    public function destroy(int $achievementId)
    {
        if ($this->achievementStorage->delete($achievementId)) {
            return response()->json([], 204);
        } else {
            return response()->json([], 400);
        }
    }

    public function modifyPosition(AchievementPositionRequest $request)
    {
        $this->achievementPositionService->modifyPosition(AchievementPositionDto::fromFormRequest($request));

        return response()->json([], 200);
    }
}
