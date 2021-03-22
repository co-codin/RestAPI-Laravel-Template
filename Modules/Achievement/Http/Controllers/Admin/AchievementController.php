<?php

namespace Modules\Achievement\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Dto\AchievementPositionDto;
use Modules\Achievement\Http\Requests\AchievementPositionRequest;
use Modules\Achievement\Http\Requests\AchievementRequest;
use Modules\Achievement\Repositories\AchievementRepository;
use Modules\Achievement\Services\AchievementPositionService;
use Modules\Achievement\Services\AchievementStorage;
use Modules\Achievement\Transformers\AchievementResource;

class AchievementController extends Controller
{
    protected AchievementStorage $achievementStorage;
    protected AchievementPositionService $achievementPositionService;
    protected AchievementRepository $achievementRepository;

    public function __construct(
        AchievementStorage $achievementStorage,
        AchievementPositionService $achievementPositionService,
        AchievementRepository $achievementRepository
    )
    {
        $this->achievementStorage = $achievementStorage;
        $this->achievementPositionService = $achievementPositionService;
        $this->achievementRepository = $achievementRepository;
    }

    public function index()
    {
        $achievements = $this->achievementRepository->all();

        return AchievementResource::collection($achievements);
    }

    public function show(int $achievement)
    {
        $achievementModel = $this->achievementRepository->find($achievement);

        return new AchievementResource($achievement);
    }

    public function store(AchievementRequest $request)
    {
        $achievement = $this->achievementStorage->store(AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievement);
    }

    public function update(int $achievement, AchievementRequest $request)
    {
        $achievementModel = $this->achievementStorage->update($achievement, AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievementModel);
    }

    public function destroy(int $achievement)
    {
        abort_unless($this->achievementStorage->delete($achievement), 500, 'Не удалось удалить достижения');

        return response()->noContent();
    }

    public function modifyPosition(AchievementPositionRequest $request)
    {
        $this->achievementPositionService->modifyPosition(AchievementPositionDto::fromFormRequest($request));

        return response()->json([], 200);
    }
}
