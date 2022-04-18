<?php

namespace Modules\Banner\Services;

use Modules\Banner\Models\Banner;

class BannerStorage
{
    public function store(array $data)
    {
        return Banner::query()->create($data);
    }

    public function update(Banner $banner, array $data)
    {
        if (!$banner->update($data)) {
            throw new \LogicException('can not update banner');
        }

        return $banner;
    }

    public function delete(Banner $banner)
    {
        if (!$banner->delete()) {
            throw new \LogicException('can not delete banner');
        }
    }

    public function sort(array $banners)
    {
        foreach ($banners as $banner) {
            Banner::query()
                ->where('id', $banner['id'])
                ->update(['position' => $banner['position']]);
        }
    }
}
