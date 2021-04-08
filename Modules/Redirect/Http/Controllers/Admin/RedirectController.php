<?php


namespace Modules\Redirect\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
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

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {
        
    }
}
