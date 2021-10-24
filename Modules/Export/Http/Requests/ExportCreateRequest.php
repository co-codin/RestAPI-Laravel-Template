<?php

namespace Modules\Export\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Product\Enums\Availability;

class ExportCreateRequest extends FormRequest
{
    use ExportFilterRequest {
        ExportFilterRequest::rules as filterRules;
    }

    public function rules(): array
    {
        return array_merge([
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                'integer',
                new EnumValue(ExportType::class, false),
            ],
            'filename' => 'required|string|max:255|unique:exports,filename',
            'frequency' => [
                'required',
                'integer',
                new EnumValue(ExportFrequency::class, false),
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',
        ], $this->filterRules());
    }
}
