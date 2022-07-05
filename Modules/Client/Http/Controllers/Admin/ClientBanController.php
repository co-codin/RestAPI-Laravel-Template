<?php

namespace Modules\Client\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Client\Models\Client;

class ClientBanController extends Controller
{
    public function ban(Client $client)
    {
        $this->authorize('ban', auth('auth:sanctum')->user());

        $client->ban();

        return $client;
    }

    public function unban(Client $client): Client
    {
        $this->authorize('unban', auth('auth:sanctum')->user());

        $client->unban();

        return $client;
    }
}
