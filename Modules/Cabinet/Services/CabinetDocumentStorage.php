<?php

namespace Modules\Cabinet\Services;

use Modules\Cabinet\Models\Cabinet;

class CabinetDocumentStorage
{
    public function update(Cabinet $cabinet, array $documents)
    {
        $cabinet->documents()->delete();
            foreach ($documents as $document) {
                foreach($document['docs'] as $doc) {
                    $cabinet->documents()->create([
                        'name' => $doc['name'],
                        'group_name' => $document['group_name'],
                        'type' => $doc['type'],
                        'source' => $doc['source'],
                        'file' => $doc['file'] ?? null,
                        'link' => $doc['link'] ?? null,
                    ]);
                }
            }
    }
}
