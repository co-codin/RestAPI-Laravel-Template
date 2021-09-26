<?php


namespace Modules\Filter\Concerns;


use Illuminate\Support\Collection;

trait HasValue
{
    public function parseValue($value)
    {
        return $value;
    }

    public function validateValue($value) : bool
    {
        return !! $value;
    }

//    public function getValueAttribute($value)
//    {
//
//    }

    public function getUrlAttribute()
    {
        return $this->slug . '-' . $this->value;
    }

    public function setValueAttribute($value)
    {
        $value = $this->parseValue($value);

        $this->attributes['value'] = $value;
    }

    public function getIsEnabledAttribute() : bool
    {
        return !! $this->value;
    }

    protected function getParsedUrl() : Collection
    {
        return collect(explode("/", request()->filters))
            ->mapWithKeys(function($part) {
                $value = explode("-", $part, 2);
                return [$value[0] => isset($value[1]) ? $value[1] : null];
            });
    }
}
