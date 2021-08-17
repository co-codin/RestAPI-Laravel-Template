<?php


namespace Modules\Seo\Services;


use Modules\Seo\Dto\SeoRuleDto;
use Modules\Seo\Models\SeoRule;

class SeoRuleStorage
{
    public function store(SeoRuleDto $seoRuleDto)
    {
        $attributes = $seoRuleDto->toArray();

        $attributes['assigned_by_id'] = $redirectDto->assigned_by_id ?? auth('custom-token')->id();

        return SeoRule::query()->create($attributes);
    }

    public function update(SeoRule $seoRule, SeoRuleDto $seoRuleDto)
    {
        $attributes = $seoRuleDto->toArray();

        $attributes['assigned_by_id'] = $redirectDto->assigned_by_id ?? null;

        if (!$seoRule->update($attributes)) {
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
