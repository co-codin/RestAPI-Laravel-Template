<?php


namespace App\Http\RequestFilters;


use BinaryCats\Sanitizer\Laravel\SanitizesInput as BaseSanitizesInput;

trait SanitizesInput
{
    use BaseSanitizesInput;

    public function customFilters()
    {
        return [
            'nullable-cast' => NullableCast::class,
        ];
    }
}
