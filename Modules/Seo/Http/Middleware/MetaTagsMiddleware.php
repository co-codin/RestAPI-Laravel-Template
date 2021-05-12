<?php

namespace Modules\Seo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Modules\Seo\Facades\Canonical as CanonicalFacade;
use Modules\Seo\Facades\MetaTags as MetaTagsFacade;
use Modules\Seo\Repositories\CanonicalRepository;
use Modules\Seo\Repositories\SeoRuleRepository;

/**
 * Class MetaTagsMiddleware
 * @package Modules\Seo\Http\Middleware
 */
class MetaTagsMiddleware
{
    /**
     * The ROUTE NAMES that should be excluded from MetaTagsMiddleware.
     *
     * @var array
     */
    protected array $except = [
        'product-view',
        'category-view',
        'brand-view',
        'news-view',
    ];

    public function __construct(
        private SeoRuleRepository $seoRuleRepository,
        private CanonicalRepository $canonicalRepository
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $pathInfo = $request->getPathInfo();

        $this->setCanonical($pathInfo);

        if (!$this->inExceptArray($request)) {
            $this->setSeo($pathInfo);
        }

        return $next($request);
    }

    /**
     * @param string $pathInfo
     */
    private function setCanonical(string $pathInfo): void
    {
        $canonical = $this->canonicalRepository->findByUrl($pathInfo);

        if (!is_null($canonical)) {
            CanonicalFacade::setCanonical($canonical->canonical);
        }
    }

    /**
     * @param string $pathInfo
     * @return void
     */
    private function setSeo(string $pathInfo): void
    {
        $seoRule = $this->seoRuleRepository->findByUrl($pathInfo);

        if (!is_null($seoRule)) {
            MetaTagsFacade::setSeo($seoRule->seoEnabled)
                ->setSeoRuleText($seoRule->text);
        }
    }

    /**
     * Determine if the request has a route that shouldn't use MetaTagsManager.
     *
     * @param Request $request
     * @return bool
     */
    private function inExceptArray(Request $request): bool
    {
        $routeName = $this
            ->getRouteByRequest($request)
            ->getName();

        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($except === $routeName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @return Route
     */
    private function getRouteByRequest(Request $request): Route
    {
        return app('router')
            ->getRoutes()
            ->match($request);
    }
}
