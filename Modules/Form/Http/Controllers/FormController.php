<?php

namespace Modules\Form\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Form\Http\Requests\FormsRequest;
use Modules\Form\Http\Requests\VacancyFormRequest;
use Modules\Form\Mail\SubscribeNotify;
use Modules\Form\Mail\VacancyMail;
use Modules\Form\Services\FormPreparerService;
use Modules\Form\Services\FormSendService;

/**
 * Class FormController
 * @package Modules\Form\Http\Controllers
 */
class FormController extends Controller
{
    /**
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

    /**
     * @throws \Throwable
     */
    public function subscribe(
        FormsRequest $request,
        FormPreparerService $prepareDataService,
        FormSendService $sendService
    ): JsonResponse
    {
        $form = $prepareDataService->getPreparedForm($request);
        $sendService->send($form);

        \Mail::to($form->getEmail())
            ->queue(new SubscribeNotify());

        return response()->json(
            $request->getForm()->response()
        );
    }

    public function vacancy(VacancyFormRequest $request)
    {
        $email = 'hr.info@medeq.ru';

        Mail::to($email)->send(new VacancyMail($request->validated()));
    }
}
