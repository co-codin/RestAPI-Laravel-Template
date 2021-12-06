<?php


namespace App\Http\Middleware;


use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientAuth extends Middleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = Http::baseUrl(config('services.crm.domain'))
            ->withToken($request->bearerToken())
            ->get('/clients/show');

        if ($response->failed()) {
            abort(401);
        }

        $request->offsetSet('client', $response->json());

        return $next($request);
    }
}
