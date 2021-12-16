<?php


namespace Modules\Review\Http\Middleware;


use App\Helpers\RateHelper;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductReviewRateMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        $rates = collect(unserialize(\Cookie::get('product_review_rate')) ?? []);
        $productReviewId = (int)$request->route('product_review');

        RateHelper::rate($request, $rates, $productReviewId);

        return $next($request);
    }
}
