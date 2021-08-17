<?php


namespace Modules\Redirect\Services;


use Modules\Redirect\Dto\RedirectDto;
use Modules\Redirect\Models\Redirect;

class RedirectStorage
{
    public function store(RedirectDto $redirectDto)
    {
        $attributes = $redirectDto->toArray();

        $attributes['assigned_by_id'] = $redirectDto->assigned_by_id ?? auth('custom-token')->id();

        return Redirect::query()->create($attributes);
    }

    public function update(Redirect $redirect, RedirectDto $redirectDto)
    {
        $attributes = $redirectDto->toArray();

        $attributes['assigned_by_id'] = $redirectDto->assigned_by_id ?? null;

        if (!$redirect->update($attributes)) {
            throw new \LogicException('can not update redirect');
        }
        return $redirect;
    }

    public function delete(Redirect $redirect)
    {
        if (!$redirect->delete()) {
            throw new \LogicException('can not delete redirect');
        }
    }
}
