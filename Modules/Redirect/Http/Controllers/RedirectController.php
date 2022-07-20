<?php


namespace Modules\Redirect\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Redirect\Http\Resources\RedirectResource;
use Modules\Redirect\Models\Redirect;
use Modules\Redirect\Repositories\RedirectRepository;

class RedirectController extends Controller
{
    public function __construct(
        protected RedirectRepository $redirectRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Redirect::class);

        $redirects = $this->redirectRepository->jsonPaginate();

        return RedirectResource::collection($redirects);
    }

    public function show(int $redirect)
    {
        $redirect = $this->redirectRepository->find($redirect);

        $this->authorize('view', $redirect);

        return new RedirectResource($redirect);
    }
}
