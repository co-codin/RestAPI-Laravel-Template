<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ImageUploader extends FileUploader
{
    protected int $maxWidth = 2000;

    protected int $maxHeight = 2000;

    protected string $fit = Manipulations::FIT_MAX;

    public function upload(UploadedFile $file): string
    {
        $path = parent::upload($file);

        $fullPath = $this->fullFilePath($path);

        $this->resize($fullPath);
        $this->convert($fullPath, Manipulations::FORMAT_WEBP);

        return $path;
    }

    public function setMaxWidth(int $maxWidth): static
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    public function setMaxHeight(int $maxHeight): static
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    public function setFit(string $fit): static
    {
        $this->fit = $fit;

        return $this;
    }

    protected function resize($path)
    {
        Image::load($path)
            ->fit($this->fit, $this->maxWidth, $this->maxHeight)
            ->save();
    }

    protected function convert($path, string $format)
    {
        Image::load($path)
            ->save( $path . "." . $format);
    }
}
