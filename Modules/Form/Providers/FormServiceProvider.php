<?php

namespace Modules\Form\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Form\Helpers\FormRequestHelper;
use Modules\Form\Repositories\Contracts\DealRepository;
use Modules\Form\Repositories\Contracts\DepartmentRepository;
use Modules\Form\Repositories\Contracts\LeadRepository;
use Modules\Form\Repositories\Contracts\ManagerRepository;
use Modules\Form\Repositories\DealBitrix24Repository;
use Modules\Form\Repositories\DepartmentBitrix24Repository;
use Modules\Form\Repositories\LeadBitrix24Repository;
use Modules\Form\Repositories\ManagerBitrix24Repository;

class FormServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Form';
    protected string $moduleNameLower = 'form';

    /**
     * Boot the application events.
     *
     * @return void
     */
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

        $this->app->singleton(FormRequestHelper::class);

        $this->app->bind(
            DepartmentRepository::class,
            DepartmentBitrix24Repository::class
        );

        $this->app->bind(
            ManagerRepository::class,
            ManagerBitrix24Repository::class
        );

        $this->app->bind(
            DealRepository::class,
            DealBitrix24Repository::class
        );

        $this->app->bind(
            LeadRepository::class,
            LeadBitrix24Repository::class
        );
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
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

    public function registerTranslations()
    {
        $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
    }
}
