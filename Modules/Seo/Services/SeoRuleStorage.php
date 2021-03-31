<?php


namespace Modules\Seo\Services;


use Modules\Seo\Models\SeoRule;

class SeoRuleStorage
{
    public function store()
    {

    }

    public function update()
    {

    }

    public function delete(SeoRule $seoRule)
    {
        if (!$seoRule->delete()) {
            throw new \LogicException('can not delete seo rule');
        }
    }
}
