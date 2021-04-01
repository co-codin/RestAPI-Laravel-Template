<?php


namespace Modules\Seo\Services;


use Modules\Seo\Dto\SeoRuleDto;
use Modules\Seo\Models\SeoRule;

class SeoRuleStorage
{
    public function store(SeoRuleDto $seoRuleDto)
    {
        return SeoRule::query()->create($seoRuleDto->toArray());
    }

    public function update(SeoRule $seoRule, SeoRuleDto $seoRuleDto)
    {
        if (!$seoRule->update($seoRuleDto->toArray())) {
            throw new \LogicException('can not update seo rule');
        }
        return $seoRule;
    }

    public function delete(SeoRule $seoRule)
    {
        if (!$seoRule->delete()) {
            throw new \LogicException('can not delete seo rule');
        }
    }
}
