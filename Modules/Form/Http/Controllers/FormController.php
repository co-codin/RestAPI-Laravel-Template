<?php

namespace Modules\Form\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Form\Http\Requests\FormsRequest;
use Modules\Form\Services\FormPreparerService;
use Modules\Form\Services\FormSendService;

/**
 * Class FormController
 * @package Modules\Form\Http\Controllers
 */
class FormController extends Controller
{
    /**
     * @param FormsRequest $request
     * @param FormPreparerService $prepareDataService
     * @param FormSendService $sendService
     * @return JsonResponse
     * @throws \Throwable
     */
    public function send(
        FormsRequest $request,
        FormPreparerService $prepareDataService,
        FormSendService $sendService
    ): JsonResponse
    {
        $form = $prepareDataService->getPreparedForm($request);

        $sendService->send($form);

        return response()->json(
            $request->getForm()->response()
        );
    }
}
