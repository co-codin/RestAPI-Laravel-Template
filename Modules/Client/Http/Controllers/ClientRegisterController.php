<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Http\Requests\FastRegisterRequest;
use Modules\Client\Models\Client;

class ClientRegisterController extends Controller
{
    public function fastRegister(FastRegisterRequest $request)
    {
        $client = Client::firstOrCreate(['phone' => $request->validated()['phone']]);

        return response()->json([
            'id' => $client->id,
            'phone' => $client->phone,
        ], 201);
    }
}
