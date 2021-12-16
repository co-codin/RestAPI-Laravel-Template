<?php

namespace Modules\Cabinet\Services;

use App\Services\File\FileUploader;
use Illuminate\Support\Arr;
use Modules\Cabinet\Models\Cabinet;
use Illuminate\Http\UploadedFile;

class CabinetDocumentStorage
{
    public function __construct(
        protected FileUploader $fileUploader
    ) {}

    public function update(Cabinet $cabinet, array $documents)
    {
        $cabinet->documents()->delete();
        foreach ($documents as $document) {
            foreach ($document['docs'] as $doc) {
                if (Arr::exists($doc, 'file') && !is_null($doc['file']) ) {
                    $path = $this->fileUploader->upload($doc['file']);
                    $doc['file'] = $path;
                }
                $cabinet->documents()->create([
                    'name' => $doc['name'],
                    'document_group_id' => $document['document_group_id'],
                    'type' => $doc['type'],
                    'source' => $doc['source'],
                    'file' => $doc['file'],
                    'link' => $doc['link'],
                ]);
            }
        }
    }
}
