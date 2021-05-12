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
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
