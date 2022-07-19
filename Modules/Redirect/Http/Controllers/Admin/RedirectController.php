<?php


namespace Modules\Redirect\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Redirect\Dto\RedirectDto;
use Modules\Redirect\Http\Requests\RedirectCreateRequest;
use Modules\Redirect\Http\Requests\RedirectUpdateRequest;
use Modules\Redirect\Http\Resources\RedirectResource;
use Modules\Redirect\Models\Redirect;
use Modules\Redirect\Repositories\RedirectRepository;
use Modules\Redirect\Services\RedirectStorage;

class RedirectController extends Controller
{
    public function __construct(
        protected RedirectStorage $redirectStorage
    ) {
        $this->authorizeResource(Redirect::class, 'redirect');
    }

    public function store(RedirectCreateRequest $request)
    {
        $redirectDto = RedirectDto::fromFormRequest($request);

        if (!$redirectDto->assigned_by_id) {
            $redirectDto->assigned_by_id = auth('sanctum')->id();
        }

        $redirectModel = $this->redirectStorage->store($redirectDto);

        return new RedirectResource($redirectModel);
    }

    public function update(Redirect $redirect, RedirectUpdateRequest $request)
    {
        $redirect = $this->redirectStorage->update($redirect, (new RedirectDto($request->validated()))->only(...$request->keys()));

        return new RedirectResource($redirect);
    }

    public function destroy(Redirect $redirect)
    {
        $this->redirectStorage->delete($redirect);

        return response()->noContent();
    }
}
