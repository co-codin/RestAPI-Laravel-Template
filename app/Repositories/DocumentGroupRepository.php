<?php

namespace App\Repositories;

use App\Models\DocumentGroup;
use App\Repositories\Criteria\DocumentGroupRequestCriteria;

class DocumentGroupRepository extends BaseRepository
{
    public function model()
    {
        return DocumentGroup::class;
    }

    public function boot()
    {
        $this->pushCriteria(DocumentGroupRequestCriteria::class);
    }
}
