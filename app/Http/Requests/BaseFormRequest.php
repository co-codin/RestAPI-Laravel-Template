<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class BaseFormRequest extends FormRequest
{
    protected function passedValidation(): void
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
