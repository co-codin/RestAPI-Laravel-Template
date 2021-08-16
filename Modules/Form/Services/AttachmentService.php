<?php


namespace Modules\Form\Services;


use Illuminate\Http\UploadedFile;

class AttachmentService
{
    /**
     * @param UploadedFile[] $files
     * @return string[]
     * @throws \Exception
     */
    public function save(array $files): array
    {
        $filePaths = [];
        $files = \Arr::flatten($files);

        foreach ($files as $file) {
            $filePaths[] = $this->saveFile($file);
        }

        return $filePaths;
    }

    /**
     * @param UploadedFile $file
     * @return string
     * @throws \Exception
     */
    private function saveFile(UploadedFile $file): string
    {
        $result = \Storage::putFileAs('uploads/temp', $file, $file->getClientOriginalName());

        if (!$result) {
            throw new \Exception('Don\'t save file - ' . $file->getClientOriginalName());
        }

        return 'uploads/temp/' . $file->getClientOriginalName();
    }

    /**
     * @param string[] $paths
     * @return bool
     */
    public function delete(array $paths): bool
    {
        return \Storage::delete($paths);
    }
}
