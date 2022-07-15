<?php

namespace Modules\Achievement\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\IsEnabledCriteria;
use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Http\Requests\AchievementSortRequest;
use Modules\Achievement\Http\Requests\AchievementCreateRequest;
use Modules\Achievement\Http\Requests\AchievementUpdateRequest;
use Modules\Achievement\Http\Resources\AchievementResource;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\AchievementRepository;
use Modules\Achievement\Services\AchievementStorage;

class AchievementController extends Controller
{
    public function __construct(
        protected AchievementStorage $achievementStorage,
        protected AchievementRepository $achievementRepository
    ){
        $this->achievementRepository->popCriteria(IsEnabledCriteria::class);
        $this->authorizeResource(Achievement::class, 'achievement');
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

    public function sort(AchievementSortRequest $request)
    {
        $this->achievementStorage->sort($request->input('achievements'));

        return response()->noContent();
    }
}
