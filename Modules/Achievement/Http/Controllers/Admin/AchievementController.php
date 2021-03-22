<?php

namespace Modules\Achievement\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Dto\AchievementPositionDto;
use Modules\Achievement\Http\Requests\AchievementPositionRequest;
use Modules\Achievement\Http\Requests\AchievementCreateRequest;
use Modules\Achievement\Http\Requests\AchievementUpdateRequest;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\AchievementRepository;
use Modules\Achievement\Services\AchievementPositionService;
use Modules\Achievement\Services\AchievementStorage;
use Modules\Achievement\Transformers\AchievementResource;

class AchievementController extends Controller
{
    protected AchievementStorage $achievementStorage;
    protected AchievementRepository $achievementRepository;

    public function __construct(
        AchievementStorage $achievementStorage,
        AchievementRepository $achievementRepository
    )
    {
        $this->achievementStorage = $achievementStorage;
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

        return new AchievementResource($achievementModel);
    }

    public function store(AchievementCreateRequest $request)
    {
        $achievement = $this->achievementStorage->store(AchievementDto::fromFormRequest($request));

        return new AchievementResource($achievement);
    }

    public function update(int $achievement, AchievementUpdateRequest $request)
    {
        $achievementModel = Achievement::query()->firstOrFail($achievement);

        $item = $this->achievementStorage->update($achievementModel, AchievementDto::fromFormRequest($request));

        return new AchievementResource($item);
    }

    public function destroy(int $achievement)
    {
        $achievementModel = Achievement::query()->firstOrFail($achievement);

        abort_unless($this->achievementStorage->delete($achievementModel), 500, 'Не удалось удалить достижения');

        return response()->noContent();
    }

    public function modifyPosition(AchievementPositionRequest $request, AchievementPositionService $achievementPositionService)
    {
        $achievementPositionService->modifyPosition($request->get('ids'));

        return response()->json([], 200);
    }
}
