<?php

namespace Modules\Banner\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Banner\Enums\BannerPage;

class BannerUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return  [
            'name' => 'required|string|max:255|unique:banners,name,' . $this->route('banner'),
            'page' => [
                'required',
                'string',
                new EnumValue(BannerPage::class, false)
            ],
            'is_in_home' => 'sometimes|boolean',
            'images' => 'required|array',
            'position' => 'sometimes|nullable|integer',
            'url' => 'required|url|max:255',
        ];
    }
}
