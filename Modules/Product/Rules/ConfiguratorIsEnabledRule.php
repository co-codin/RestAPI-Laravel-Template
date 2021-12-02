<?php


namespace Modules\Product\Rules;

use Illuminate\Contracts\Validation\Rule;

class ConfiguratorIsEnabledRule implements Rule
{
    public function passes($attribute, $value)
    {
        $isEnabled = array_column($value, 'is_enabled');

        return count(array_filter($isEnabled)) >= 1;
    }

    public function message()
    {
        return 'At least one is_enabled should be true.';
    }
}
