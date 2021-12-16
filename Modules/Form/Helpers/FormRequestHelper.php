<?php


namespace Modules\Form\Helpers;


use App\Helpers\DirectoryHelper;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Form\Forms\Form;
use Modules\Form\Validators\FormValidator;
use function request;

class FormRequestHelper
{
    private ?Form $form = null;

    public function getForm(): Form
    {
        if (!is_null($this->form)) {
            return $this->form;
        }

        $requestData = $this->getValidatedRequestData();
        request()->offsetSet('roistatVisit', $requestData['roistatVisit']);

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
            $formName = request()->formName;
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
}
