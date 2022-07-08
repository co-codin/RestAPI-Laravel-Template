<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClientUploadImageRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|file|image|max:5120',
            'crop' => 'required|array',
            'crop.x' => 'required|integer|min:0',
            'crop.y' => 'required|integer|min:0',
            'crop.width' => 'required|integer|min:200|same:crop.height',
            'crop.height' => 'required|integer|min:200|same:crop.width',
            'crop.rotate' => 'required|integer|in:90,180,270,0,-90,-180,-270',
        ];
    }

    public function attributes(): array
    {
        return [
            'crop.x' => 'Координата x оси верхней левой точки',
            'crop.y' => 'Координата y оси верхней левой точки ',
            'crop.width' => 'Ширина кадрированного изображения',
            'crop.height' => 'Высота кадрированного изображения',
            'crop.rotate' => 'Градус поворота изображения',
        ];
    }
}
