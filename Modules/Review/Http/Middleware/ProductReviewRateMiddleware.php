<?php


namespace Modules\Review\Http\Middleware;


use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Review\Enums\ProductReviewRateStatus;

class ProductReviewRateMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        $rates = collect(\Cookie::get('product_review_rate'));

        $prevStatus = (int)$rates->get($request->query('id'));
        $status = ProductReviewRateStatus::fromValue($request->input('status'));

        if ($prevStatus === $status->value) {
            abort(401);
        }

        $request->offsetSet('prev_status', $prevStatus);

        return $next($request);
    }
}
