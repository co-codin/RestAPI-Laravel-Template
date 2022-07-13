<?php

namespace Modules\Role\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Role\Http\Requests\RoleCreateRequest;
use Modules\Role\Http\Requests\RoleUpdateRequest;
use Modules\Role\Models\Role;
use Modules\Role\Repositories\RoleRepository;
use Modules\Role\Services\RoleStorage;

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

    }

    public function update(RoleUpdateRequest $request)
    {

    }

    public function destroy()
    {

    }
}
