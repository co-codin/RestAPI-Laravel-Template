<?php

namespace Modules\Geo\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Geo\Enums\OrderPointType;

class OrderPointUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'city_id' => 'sometimes|required|exists:cities,id',
            'address' => 'sometimes|required|string',
            'coordinate' => 'sometimes|required|array',
            'coordinate.lat' => 'sometimes|required|numeric',
            'coordinate.long' => 'sometimes|required|numeric',
            'phone' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email|string',
            'info' => 'sometimes|nullable|string',
            'timetable' => 'sometimes|nullable|array',
            'type' => [
                'sometimes',
                'required',
                new EnumValue(OrderPointType::class, false)
            ],
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false)
            ],
            'embed_map_url' => 'nullable|string',
        ];
    }
}
