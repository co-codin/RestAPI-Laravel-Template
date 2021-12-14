<?php

namespace Modules\Cabinet\Services;

use App\Services\File\FileUploader;
use Illuminate\Support\Arr;
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
                if (Arr::exists($document, 'file') && !empty($document['file'])) {
                    $path = $this->fileUploader->upload($document['file']);
                    $document['file'] = $path;
                } else {
                    $document['file'] = null;
                }
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
