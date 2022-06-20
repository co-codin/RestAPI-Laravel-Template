<?php

namespace Modules\Client\Http\Validators;

class ClientEmailVerifyCodePostValidator extends BaseClientVerifyCodePostValidator
{
    protected function getUniqueKey(): string
    {
        return $this->getRequest()->input('email');
    }
}
