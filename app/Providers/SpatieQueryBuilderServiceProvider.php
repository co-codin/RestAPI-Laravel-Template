<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\QueryBuilder\QueryBuilderRequest;

class SpatieQueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        QueryBuilderRequest::setIncludesArrayValueDelimiter('|'); // Includes
        QueryBuilderRequest::setAppendsArrayValueDelimiter('|');  // Appends
        QueryBuilderRequest::setFieldsArrayValueDelimiter('|');   // Fields
        QueryBuilderRequest::setSortsArrayValueDelimiter('|');    // Sorts
        QueryBuilderRequest::setFilterArrayValueDelimiter('|');   // Filter
    }
}
