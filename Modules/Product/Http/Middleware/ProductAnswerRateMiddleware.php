<?php


namespace Modules\Product\Http\Middleware;


use App\Helpers\RateHelper;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use function collect;

class ProductAnswerRateMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        $rates = collect(unserialize(\Cookie::get('product_answer_rate')) ?? []);
        $answerId = (int)$request->route('product_answer');

        RateHelper::rate($request, $rates, $answerId);

        return $next($request);
    }
}
