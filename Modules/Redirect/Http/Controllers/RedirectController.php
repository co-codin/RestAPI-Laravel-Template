<?php


namespace Modules\Redirect\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Redirect\Http\Resources\RedirectResource;
use Modules\Redirect\Repositories\RedirectRepository;

class RedirectController extends Controller
{
    public function __construct(
        protected RedirectRepository $redirectRepository
    ) {}

    public function index()
    {
        $redirects = $this->redirectRepository->jsonPaginate();

        return RedirectResource::collection($redirects);
    }

    public function show(int $redirect)
    {
        $redirect = $this->redirectRepository->find($redirect);

        return new RedirectResource($redirect);
    }
}
