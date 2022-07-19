<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Http\Requests\ClientUploadImageRequest;
use Modules\Client\Services\ClientAvatarService;

class ClientAvatarUpdateController extends Controller
{
    public function __construct(
        protected ClientAvatarService $service
    ) {}

    public function update(ClientUploadImageRequest $request)
    {
        $path = $this->service->store(
            auth('client')->user(),
            $request->validated()['image'],
            $request->validated()['crop'],
        );

        return response()->json([
            'image' => $path
        ], 201);
    }

    public function destroy()
    {
        $this->service->destroy(
            auth('client')->user()
        );

        return response()->noContent();
    }
}
