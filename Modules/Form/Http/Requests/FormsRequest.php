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
        $form = $this->getForm();
        $rules = $form->rules();

        if (!$form->withAuth) {
            $rules = array_merge($rules, [
                'phone' => 'required|string|regex:/^[\s0-9()+-]+$/|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255'
            ]);
        }

        return $rules;
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
        'name' => "string",
        'phone' => "string",
        'email' => "string"
    ])]
    public function getClientData(): array
    {
        return app(FormRequestHelper::class)->getClientData();
    }
}
