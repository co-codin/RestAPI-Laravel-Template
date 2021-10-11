<?php


namespace Modules\Form\Repositories;


use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Model;
use Modules\Form\Repositories\Contracts\RequestRepository;

class RequestMedeqstarsRepository implements RequestRepository
{
    public function findAll(): ?Collection
    {
        // TODO: Implement findAll() method.
    }

    public function findById(int $id): ? Model
    {
        // TODO: Implement findById() method.
    }
}
