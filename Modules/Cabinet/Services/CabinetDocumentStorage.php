<?php

namespace Modules\Cabinet\Services;

use Modules\Cabinet\Models\Cabinet;

class CabinetDocumentStorage
{
    public function update(Cabinet $cabinet, array $documents)
    {
        $cabinet->documents()->delete();
            foreach ($documents as $document) {
                $cabinet->documents()->create([
                    'name' => $document['name'],
                    'group_name' => $document['group_name'],
                    'type' => $document['type'],
                    'file' => $document['file'],
                ]);
            }
    }
}
