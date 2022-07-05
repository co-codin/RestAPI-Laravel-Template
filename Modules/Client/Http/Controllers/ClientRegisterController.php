<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Http\Requests\ClientFastRegisterRequest;
use Modules\Client\Http\Requests\ClientRegisterRequest;
use Modules\Client\Models\Client;

class ClientRegisterController extends Controller
{
    public function fastRegister(ClientFastRegisterRequest $request)
    {
        $client = Client::firstOrCreate(['phone' => $request->validated()['phone']]);

        return response()->json([
            'id' => $client->id,
            'phone' => $client->phone,
        ], 201);
    }

    public function register(ClientRegisterRequest $request)
    {
        return Client::query()->create($request->validated());
    }
}
