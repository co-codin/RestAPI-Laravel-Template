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
    ) {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        $roles = $this->roleRepository->jsonPaginate();

        return RoleResource::collection($roles);
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }
}
