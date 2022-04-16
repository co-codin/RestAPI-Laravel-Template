<?php

namespace Modules\Banner\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Banner\Enums\BannerPage;

class BannerCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return  [
            'name' => 'required|string|max:255|unique:banners,name',
            'page' => [
                'required',
                'string',
                new EnumValue(BannerPage::class, false)
            ],
            'is_in_home' => 'sometimes|boolean',
            'images' => 'required|array',
            'images.desktop' => 'required|string',
            'images.tablet' => 'required|string',
            'images.mobile' => 'required|string',
            'position' => 'sometimes|nullable|integer',
            'url' => 'required|url|max:255',
        ];
    }
}
