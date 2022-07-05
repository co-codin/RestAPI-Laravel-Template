<?php

namespace Modules\Client\Http\Validators;


use App\Http\Validators\BasePostValidator;
use Modules\Client\Helpers\CodeVerifyHelper;

abstract class BaseClientVerifyCodePostValidator extends BasePostValidator
{
    abstract protected function getUniqueKey(): string;

    protected function check(): void
    {
        try {
            CodeVerifyHelper::validateCode(
                $this->getUniqueKey(),
                $this->getRequest()->input('code')
            );
        } catch (\Exception $e) {
            $this->addError('code', $e->getMessage());
        }
    }
}
