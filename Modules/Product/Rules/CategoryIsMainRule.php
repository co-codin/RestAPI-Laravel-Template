<?php


namespace Modules\Product\Rules;

use Illuminate\Contracts\Validation\Rule;

class CategoryIsMainRule implements Rule
{
    public function passes($attribute, $value)
    {
        $isMain = array_column($value, 'is_main');

        return count(array_filter($isMain)) === 1;
    }

    public function message()
    {
        return 'is_main should be unique in array.';
    }
}
