<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

abstract class BasePostValidator
{
    private Validator $_validator;
    private Request $_request;

    abstract protected function check();

    protected function __construct(Validator $validator)
    {
        $this->_validator = $validator;
        $this->_request = request();
    }

    public static function run(Validator $validator): void
    {
        $obj = new static($validator);
        $obj->check();
    }

    protected function getValidator(): Validator
    {
        return $this->_validator;
    }

    protected function getRequest(): Request
    {
        return $this->_request;
    }

    protected function addError($key, $message): void
    {
        $this->getValidator()->errors()->add($key, $message);
    }
}
