<?php


namespace Modules\Redirect\Services;


use Modules\Redirect\Dto\RedirectDto;
use Modules\Redirect\Models\Redirect;

class RedirectStorage
{
    public function store(RedirectDto $redirectDto)
    {
        return Redirect::query()->create($redirectDto->toArray());
    }

    public function update(Redirect $redirect, RedirectDto $redirectDto)
    {
        if (!$redirect->update($redirectDto->toArray())) {
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
