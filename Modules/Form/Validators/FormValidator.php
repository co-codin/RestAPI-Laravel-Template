<?php


namespace Modules\Form\Validators;

use App\Helpers\DirectoryHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use LogicException;
use Modules\Form\Forms\Form;

class FormValidator
{
    /**
     * @param string $formName
     * @return FormValidator
     */
    public function validateFormName(string $formName): self
    {
        $formNames = DirectoryHelper::getFormClasses()
            ->filter(fn(string $classPath): bool => is_a($classPath, Form::class, true))
            ->map(fn(string $classPath): string => Str::kebab(class_basename($classPath)));

        $validator = Validator::make(['formName' => $formName], [
            'formName' => 'required|string|regex:/^[0-9a-z-_]+$/|max:255|in:' . $formNames->implode(','),
        ]);

        if ($validator->fails()) {
            throw new LogicException($validator->errors());
        }

        return $this;
    }

    /**
     * @param string|null $roistatVisit
     * @return FormValidator
     */
    public function validateRoistatVisit(?string $roistatVisit): self
    {
        $validator = Validator::make(['roistatVisit' => $roistatVisit], [
            'roistatVisit' => 'sometimes|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new LogicException($validator->errors());
        }

        return $this;
    }
}
