<?php

namespace Modules\Seo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Seo\Repositories\Admin\CanonicalRepository as AdminCanonicalRepository;
use Modules\Seo\Repositories\Admin\CanonicalRepositoryInterface as AdminCanonicalRepositoryInterface;

class SeoServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Seo';

    protected $moduleNameLower = 'seo';

    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(
            AdminCanonicalRepositoryInterface::class,
            AdminCanonicalRepository::class
        );
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
}
