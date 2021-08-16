<?php

namespace Tests\Unit\Modules\Form\Http\Requests;

use App\Helpers\DirectoryHelper;
use Modules\Form\Forms\Form;
use Modules\Form\Http\Requests\FormsRequest;
use Tests\TestCase;

class FormRequestTest extends TestCase
{
    public function testGetForm()
    {
        $classes = DirectoryHelper::getFormClasses();

        foreach ($classes as $class) {
            $request = (new FormsRequest([], ['formName' => $class::getName()]));
            $form = $request->getForm();

            $this->assertInstanceOf(Form::class, $form);
        }
    }
}
