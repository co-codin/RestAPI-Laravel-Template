<?php

namespace Modules\Banner\Http\Requests;


use App\Http\Requests\BaseFormRequest;

class BannersSortRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'banners' => 'required|array',
            'banners.*.id' => 'required|distinct|exists:banners,id',
            'banners.*.position' => 'required|distinct|integer|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'banners' => 'Баннеры',
            'banners.*.id' => 'ID баннеры',
            'banners.*.position' => 'Позиция баннера',
        ];
    }
}
