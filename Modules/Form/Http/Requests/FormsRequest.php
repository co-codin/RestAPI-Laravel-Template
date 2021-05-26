<?php

namespace Modules\Form\Http\Requests;

use App\Helpers\DirectoryHelper;
use Illuminate\Foundation\Http\FormRequest as FormRequestAlias;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Form\Forms\Form;
use Modules\Form\Validators\FormValidator;

/**
 * Class FormsRequest
 * @package Modules\Form\Http\Requests
 */
class FormsRequest extends FormRequestAlias
{
    private ?Form $form = null;

    public function rules(): array
    {
        $rules = $this->getForm()->rules();

        if (!$this->bearerToken()) {
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
        if (!is_null($this->form)) {
            return $this->form;
        }

        $requestData = $this->getValidatedRequestData();
        $this->offsetSet('roistatVisit', $requestData['roistatVisit']);

        return $this->form = app(
            DirectoryHelper::FORMS_PATH_WITH_BACKSLASH . "\\" . Str::studly($requestData['formName'])
        );
    }

    #[ArrayShape([
        'roistatVisit' => "array|null|string",
        'formName' => "string"
    ])]
    private function getValidatedRequestData(): array
    {
        try {
            $formName = $this->formName;
            $roistatVisit = Cookie::get('roistatVisit');

            app(FormValidator::class)
                ->validateFormName($formName)
                ->validateRoistatVisit($roistatVisit);
        } catch (\Throwable $exception) {
            abort(404, $exception->getMessage());
        }

        return [
            'roistatVisit' => $roistatVisit,
            'formName' => $formName
        ];
    }

    #[ArrayShape([
        'name' => "string",
        'phone' => "string",
        'email' => "string"
    ])]
    public function getClientData(): array
    {
        return [
            'name' => $this->input('name'),
            'phone' => $this->input('phone'),
            'email' => $this->input('email'),
        ];
    }
}
