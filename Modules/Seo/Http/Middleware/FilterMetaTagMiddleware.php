<?php


namespace Modules\Seo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Seo\Facades\MetaTags as MetaTagsFacade;

class FilterMetaTagMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (strpos(request('filters'), '-or-')) {
            MetaTagsFacade::addMetaTag('robots', 'noindex');
        }

        return $next($request);
    }
}
