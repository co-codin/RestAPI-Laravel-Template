<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\Form\Helpers\FormRequestHelper;

class ClientAuth
{
    public function handle(Request $request, \Closure $next)
    {
        $form = app(FormRequestHelper::class)->getForm();

        if (!$form->withAuth) {
            return $next($request);
        }

        $response = Http::baseUrl(config('services.crm.domain'))
            ->withToken($request->bearerToken())
            ->get('/clients/me');

        if ($response->failed()) {
            abort(401);
        }

        $request->offsetSet('client', $response->json());

        return $next($request);
    }
}
