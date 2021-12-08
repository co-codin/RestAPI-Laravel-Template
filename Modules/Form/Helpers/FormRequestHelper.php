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
    private ?array $clientData = null;

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
        'auth_name' => "string|null",
        'auth_phone' => "string",
        'auth_email' => "string|null",
        'auth_id' => "string|null",
    ])]
    public function getClientData(): array
    {
        if (!is_null($this->clientData)) {
            return $this->clientData;
        }

        $this->setClientData(request()->client);

        return $this->clientData;
    }

    public function setClientData(?array $clientData = null): self
    {
        $name = \Arr::get($clientData,'first_name') . ' ' . \Arr::get($clientData,'last_name');

        $this->clientData = [
            'auth_name' => !empty(trim($name)) ? $name : null,
            'auth_phone' => $clientData['phone'] ?? null,
            'auth_email' => $clientData['email'] ?? null,
            'auth_id' => $clientData['id'] ?? null,
        ];

        return $this;
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
