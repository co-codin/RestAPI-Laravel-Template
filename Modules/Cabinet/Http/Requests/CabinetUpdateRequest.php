<?php

namespace Modules\Cabinet\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CabinetUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:cabinets,slug,' . $this->route('cabinet'),
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|required|image',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'full_description' => 'sometimes|required|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'welcome_text' => 'sometimes|nullable|string|max:255',
            'documents' => 'sometimes|nullable|array',
            'documents.*.group_name' => 'required|string|max:255',
            'documents.*.name' => 'required|string|max:255',
            'documents.*.type' => 'required|integer',
            'documents.*.file' => 'required|string',
            'requirements' => 'sometimes|nullable|array',
            'requirements.*.key' => 'required|string|max:255',
            'requirements.*.value' => 'required|string|max:255',
            'categories' => 'sometimes|nullable|array',
            'categories.*.id' => 'required|integer',
            'categories.*.name' => 'required|string',
            'categories.*.count' => 'required|integer',
            'categories.*.price' => 'sometimes|nullable|numeric',
            'categories.*.position' => 'sometimes|nullable|integer',
        ];
    }
}