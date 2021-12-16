<?php

namespace App\Services;

use App\Models\DocumentGroup;

class DocumentGroupStorage
{
    public function store(array $data)
    {
        return DocumentGroup::query()->create($data);
    }
}
