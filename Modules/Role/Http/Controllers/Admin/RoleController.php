<?php

namespace Modules\Role\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Role\Models\Role;
use Modules\Role\Services\RoleStorage;

class RoleController extends Controller
{
    public function __construct(
        protected RoleStorage $roleStorage
    ) {
        $this->authorizeResource(Role::class, 'role');
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
