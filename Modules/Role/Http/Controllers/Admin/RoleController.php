<?php

namespace Modules\Role\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Role\Dto\RoleDto;
use Modules\Role\Http\Requests\RoleCreateRequest;
use Modules\Role\Http\Requests\RoleUpdateRequest;
use Modules\Role\Models\Role;
use Modules\Role\Services\RoleStorage;
use Modules\Role\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function __construct(
        protected RoleStorage $roleStorage
    ) {
        $this->authorizeResource(Role::class, 'role');
    }

    public function store(RoleCreateRequest $request)
    {
        $role = $this->roleStorage->store(RoleDto::fromFormRequest($request));

        return new RoleResource($role);
    }

    public function update(Role $role, RoleUpdateRequest $request)
    {
        $role = $this->roleStorage->update($role, RoleDto::fromFormRequest($request));

        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        $this->roleStorage->delete($role);

        return response()->noContent();
    }
}
