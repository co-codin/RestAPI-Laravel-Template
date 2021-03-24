<?php


namespace Modules\Achievement\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Achievement\Repositories\AchievementRepository;

class AchievementController extends Controller
{
    public function __construct(
        protected AchievementRepository $achievementRepository
    ) {}

    public function index()
    {

    }
}
