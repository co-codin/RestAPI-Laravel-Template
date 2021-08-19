<?php


namespace Modules\Filter\Concerns;


use Illuminate\Support\Arr;

trait Taggable
{
    public function getTagAttribute()
    {
        if(!$this->is_enabled) {
            return null;
        }

        if($tagFormatter = Arr::get($this->options, 'tagFormatter')) {
            return app($tagFormatter)->format($this);
        }

        return $this->getTagValue();
    }

    protected function getTagValue()
    {
        return $this->value;
    }
}
