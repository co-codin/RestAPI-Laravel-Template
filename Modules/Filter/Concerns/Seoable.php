<?php


namespace Modules\Filter\Concerns;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait Seoable
{
    public function getSeoAttribute()
    {
        if(!$this->is_enabled) {
            return null;
        }

        if($seoFormatter = Arr::get($this->options, 'seoFormatter')) {
            return app($seoFormatter)->format($this);
        }

        return $this->getSeoValue();
    }

    protected function getSeoValue()
    {
        return Str::lower($this->title);
    }
}
