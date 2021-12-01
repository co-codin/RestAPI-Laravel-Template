<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientAuth
{
    public function handle(Request $request, \Closure $next)
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
