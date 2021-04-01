<?php

namespace Modules\Seo\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Routing\Route;

class SeoRuleUrlRouteNotIn implements Rule
{
    private array $parameters;

    /**
     * $parameters['routes']  = (string[]) denied route names
     * $parameters['message'] = (string) error message
     *
     * @param array $parameters Associative array of parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param string $url
     * @return bool
     * @throws \Throwable
     */
    public function passes($attribute, $url)
    {
        $routeNames = $this->parameters['routes'];
        $route = $this->getRouteByUrl($url);

        if (is_null($route)) {
            $this->parameters['message'] = 'Неверный адрес ссылки';
            return false;
        }

        return !in_array($route->getName(), $routeNames, true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->parameters['message'] ?? trans('validation.seo_rule_url_route_not_in');
    }

    /**
     * @param string $url
     * @return Route|null
     * @throws \Throwable
     */
    private function getRouteByUrl(string $url): ?Route
    {
        try {
            return app('router')
                ->getRoutes()
                ->match(
                    app('request')->create($url)
                );
        } catch (\Throwable $e) {
            return null;
        }
    }
}
