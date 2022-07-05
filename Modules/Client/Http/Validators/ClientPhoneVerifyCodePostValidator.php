<?php

namespace Modules\Client\Http\Validators;

class ClientPhoneVerifyCodePostValidator extends BaseClientVerifyCodePostValidator
{
    protected function getUniqueKey(): string
    {
        return $this->getRequest()->input('phone');
    }
}
