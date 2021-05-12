<?php


namespace Modules\Seo\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CanonicalUpdateRequest
 * @package Modules\Seo\Http\Requests\Admin
 */
class CanonicalUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:canonicals,url,' . $this->route('canonical.id'),
            ],
            'canonical' => 'sometimes|required|string|max:255',
        ];
    }

    protected function passedValidation(): void
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
