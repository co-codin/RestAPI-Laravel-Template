<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
