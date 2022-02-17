<?php

namespace App\Services\Abstracts;

abstract class SearchAbstract
{
    public function search($query, array $mapping) {}

    protected function getSiteUrl()
    {
        return config('app.site_url');
    }

    protected function getAdminUrl()
    {
        return config('app.admin_url');
    }
}
