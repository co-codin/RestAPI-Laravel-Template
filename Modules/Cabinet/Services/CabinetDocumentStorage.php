<?php

namespace Modules\Cabinet\Services;

use App\Services\File\FileUploader;
use Modules\Cabinet\Models\Cabinet;

class CabinetDocumentStorage
{
    public function __construct(
        protected FileUploader $fileUploader
    ) {}

    public function update(Cabinet $cabinet, array $documents)
    {
        $cabinet->documents()->delete();
            foreach ($documents as $document) {
                $document['file'] = $document['file'] ? $this->fileUploader->upload($document['file']) : null;
                $cabinet->documents()->create([
                    'name' => $document['name'],
                    'group_name' => $document['group_name'],
                    'type' => $document['type'],
                    'source' => $document['source'],
                    'file' => $document['file'] ?? null,
                    'link' => $document['link'] ?? null,
                ]);
            }
    }
}
