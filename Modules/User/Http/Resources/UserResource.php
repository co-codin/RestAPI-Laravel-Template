<?php


namespace Modules\User\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Role\Http\Resources\RoleResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'permissions' => $this->whenLoaded('permissions'),
            'role' => new RoleResource($this->whenLoaded('role')),
        ]);
    }
}
