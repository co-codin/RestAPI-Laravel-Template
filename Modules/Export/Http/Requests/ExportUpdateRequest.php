<?php

namespace Modules\Export\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;

class ExportUpdateRequest extends FormRequest
{
    use ExportFilterRequest {
        ExportFilterRequest::rules as filterRules;
    }

    public function rules()
    {
        return array_merge([
            'name' => 'sometimes|required|string|max:255',
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(ExportType::class, false),
            ],
            'filename' => 'sometimes|required|string|max:255|unique:exports,filename,' . $this->route('export'),
            'frequency' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(ExportFrequency::class, false),
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',
        ], $this->filterRules());
    }
}
