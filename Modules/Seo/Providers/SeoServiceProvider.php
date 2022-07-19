<?php

namespace Modules\Seo\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Seo\Models\Canonical;
use Modules\Seo\Models\SeoRule;
use Modules\Seo\Policies\CanonicalPolicy;
use Modules\Seo\Policies\SeoRulePolicy;

class SeoServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Seo';

    protected $moduleNameLower = 'seo';

    protected array $policies = [
        SeoRule::class => SeoRulePolicy::class,
        Canonical::class => CanonicalPolicy::class,
    ];

    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerPolicies();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    public function registerTranslations()
    {
        $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
