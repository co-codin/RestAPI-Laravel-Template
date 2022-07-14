<?php

namespace Modules\Role\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Role\Dto\RoleDto;
use Modules\Role\Http\Requests\RoleCreateRequest;
use Modules\Role\Http\Requests\RoleUpdateRequest;
use Modules\Role\Models\Role;
use Modules\Role\Repositories\RoleRepository;
use Modules\Role\Services\RoleStorage;
use Modules\Role\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function __construct(
        protected RoleStorage $roleStorage,
        protected RoleRepository $roleRepository
    ) {
        $this->authorizeResource(Role::class, 'role');
    }

    public function store(RoleCreateRequest $request)
    {
        $role = $this->roleStorage->store(RoleDto::fromFormRequest($request));

        return new RoleResource($role);
    }

    public function update(int $role, RoleUpdateRequest $request)
    {
        $role = $this->roleRepository->find($role);

        $role = $this->roleStorage->update($role, RoleDto::fromFormRequest($request));

        return new RoleResource($role);
    }

    public function destroy(int $role)
    {
        $role = $this->roleRepository->find($role);

        $this->roleStorage->delete($role);

        return response()->noContent();
    }
}
