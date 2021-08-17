<?php


namespace Modules\Page\Services;


use Modules\Page\Dto\PageDto;
use Modules\Page\Models\Page;

class PageStorage
{
    public function store(PageDto $pageDto)
    {
        $attributes = $pageDto->toArray();

        $attributes['assigned_by_id'] = $pageDto->assigned_by_id ?? auth('custom-token')->id();

        return Page::query()->create($attributes);
    }

    public function update(Page $page, PageDto $pageDto)
    {
        $attributes = $pageDto->toArray();

        $attributes['assigned_by_id'] = $pageDto->assigned_by_id ?? null;

        if (!$page->update($attributes)) {
            throw new \LogicException('can not update page');
        }
        return $page;
    }

    public function delete(Page $page)
    {
        if (!$page->delete()) {
            throw new \LogicException('can not delete page');
        }
    }
}
