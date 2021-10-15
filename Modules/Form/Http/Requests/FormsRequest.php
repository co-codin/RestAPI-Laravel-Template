<?php

namespace Modules\Form\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as FormRequestAlias;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Form\Forms\Form;
use Modules\Form\Helpers\FormRequestHelper;

/**
 * Class FormsRequest
 * @package Modules\Form\Http\Requests
 */
class FormsRequest extends FormRequestAlias
{
    public function rules(): array
    {
        return $this->getForm()->rules();
    }

    public function attributes(): array
    {
        return $this->getForm()->attributeLabels();
    }

    public function messages(): array
    {
        return $this->getForm()->messages();
    }

    public function getForm(): Form
    {
        return app(FormRequestHelper::class)->getForm();
    }

    #[ArrayShape([
        'name' => "string|null",
        'phone' => "string",
        'email' => "string|null"
    ])]
    public function getClientData(): array
    {
        return app(FormRequestHelper::class)->getClientData();
    }
}
