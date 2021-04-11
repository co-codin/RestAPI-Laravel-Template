<?php


namespace Modules\Redirect\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Redirect\Dto\RedirectDto;
use Modules\Redirect\Http\Requests\RedirectCreateRequest;
use Modules\Redirect\Http\Requests\RedirectUpdateRequest;
use Modules\Redirect\Http\Resources\RedirectResource;
use Modules\Redirect\Repositories\RedirectRepository;
use Modules\Redirect\Services\RedirectStorage;

class RedirectController extends Controller
{
    public function __construct(
        protected RedirectRepository $redirectRepository,
        protected RedirectStorage $redirectStorage
    ) {}

    public function index()
    {
        $redirects = $this->redirectRepository->jsonPaginate();

        return RedirectResource::collection($redirects);
    }

    public function show(int $redirect)
    {
        $redirectModel = $this->redirectRepository->find($redirect);

        return new RedirectResource($redirectModel);
    }

    public function store(RedirectCreateRequest $request)
    {
        $redirectModel = $this->redirectStorage->store(RedirectDto::fromFormRequest($request));

        return new RedirectResource($redirectModel);
    }

    public function update(int $redirect, RedirectUpdateRequest $request)
    {
        $redirectModel = $this->redirectRepository->find($redirect);

        $redirectModel = $this->redirectStorage->update($redirectModel, (new RedirectDto($request->validated()))->only(...$request->keys()));

        return new RedirectResource($redirectModel);
    }

    public function destroy(int $redirect)
    {
        $redirectModel = $this->redirectRepository->find($redirect);

        $this->redirectStorage->delete($redirectModel);

        return response()->noContent();
    }
}