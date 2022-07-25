<?php

namespace Modules\Product\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAnswer;
use Modules\Product\Models\ProductQuestion;
use Modules\Product\Policies\ProductAnswerPolicy;
use Modules\Product\Policies\ProductPolicy;
use Modules\Product\Policies\ProductQuestionPolicy;
use Modules\Product\Reporters\VariationLinkReporter;

class ProductServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Product';

    protected $moduleNameLower = 'product';

    protected array $policies = [
        Product::class => ProductPolicy::class,
        ProductQuestion::class => ProductQuestionPolicy::class,
        ProductAnswer::class => ProductAnswerPolicy::class,
    ];

    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerPolicies();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(VariationLinkReporter::class);
    }

    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
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
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
