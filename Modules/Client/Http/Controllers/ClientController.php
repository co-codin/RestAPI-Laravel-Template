<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Http\Requests\ClientActivityStoreRequest;
use Modules\Client\Http\Requests\ClientUpdateRequest;

class ClientController extends Controller
{
    public function show()
    {
        return auth('client-api')->user();
    }

    public function update(ClientUpdateRequest $request): void
    {
        auth()->user()->update($request->validated());
    }

    public function activity(ClientActivityStoreRequest $request): void
    {
        activity()
            ->causedBy(auth('client-api')->user())
            ->withProperties($request->validated()['data'])
            ->log($request->validated()['action']);
    }
}
