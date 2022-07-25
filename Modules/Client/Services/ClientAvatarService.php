<?php

namespace Modules\Client\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class ClientAvatarService
{
    public function store(
        Authenticatable $client,
        UploadedFile $image,
        array $crop,
    ): string
    {
        $existAvatar = $client->avatar;

        $fileName = uniqid('', true) . '.' . $image->getClientOriginalExtension();

        $image->move($this->getUploadPath(), $fileName);

        $this->rebuildImage($fileName, $crop);

        $updated = auth('client')->user()->update([
            'avatar' => $path = Storage::url($this->getUploadDir() . $fileName)
        ]);

        if ($existAvatar && $updated) {
            File::delete(public_path($existAvatar));
        }

        return $path;
    }

    public function destroy(Authenticatable $client): void
    {
        if (!File::delete(public_path($client->avatar)) || !$client->update(['avatar' => null])) {
            throw new \Exception('Avatar cannot be deleted ');
        }
    }

    protected function getUploadPath(): string
    {
        return storage_path('app/public/' . $this->getUploadDir());
    }

    protected function getUploadDir(): string
    {
        return sprintf("avatars/%d/%s/", date('Y'), date('m'));
    }

    protected function rebuildImage(string $fileName, array $crop): void
    {
        $imageManager = Image::make($this->getUploadPath() . $fileName);

        $imageManager->rotate(-$crop['rotate']);

        $imageManager->crop($crop['width'], $crop['height'], $crop['x'], $crop['y']);

        $imageManager->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $imageManager->save();
    }
}
