<?php

namespace Modules\Role\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Role\Http\Resources\RoleResource;
use Modules\Role\Models\Role;
use Modules\Role\Repositories\RoleRepository;

class RoleController extends Controller
{
    public function __construct(
        protected RoleRepository $roleRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = $this->roleRepository->jsonPaginate();

        return RoleResource::collection($roles);
    }

    public function show(int $role)
    {
        $role = $this->roleRepository->find($role);

        $this->authorize('view', $role);

        return new RoleResource($role);
    }
}
