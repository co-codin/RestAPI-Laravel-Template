<?php


namespace App\Http\Middleware;


use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\Form\Helpers\FormRequestHelper;

class ClientFormAuth extends Middleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        $formHelper = app(FormRequestHelper::class);

        if (!$formHelper->getForm()->withAuth) {
            return $next($request);
        }

        $response = Http::baseUrl(config('services.crm.domain'))
            ->withToken($request->bearerToken())
            ->get('/clients/me');

        if ($response->failed()) {
            abort(401);
        }

        $request->offsetSet('client', $response->json());
        $formHelper->setClientData($response->json());

        return $next($request);
    }
}
