<?php


namespace Modules\Qna\Http\Middleware;


use App\Helpers\RateHelper;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnswerRateMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        $rates = collect(unserialize(\Cookie::get('answer_rate')) ?? []);
        $answerId = (int)$request->route('answer');

        RateHelper::rate($request, $rates, $answerId);

        return $next($request);
    }
}
