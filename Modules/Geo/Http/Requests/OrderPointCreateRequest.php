<?php

namespace Modules\Geo\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Geo\Enums\OrderPointType;

class OrderPointCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'coordinate' => 'required|array',
            'coordinate.lat' => 'required|numeric',
            'coordinate.long' => 'required|numeric',
            'phone' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email|string',
            'info' => 'sometimes|nullable|string',
            'timetable' => 'sometimes|nullable|array',
            'type' => [
                'required',
                new EnumValue(OrderPointType::class, false)
            ],
            'status' => [
                'required',
                new EnumValue(Status::class, false)
            ],
            'embed_map_url' => 'nullable|string',
        ];
    }
}
