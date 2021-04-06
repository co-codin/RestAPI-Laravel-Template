<?php


namespace Modules\Page\Services;


use Modules\Page\Dto\PageDto;
use Modules\Page\Models\Page;

class PageStorage
{
    public function store(PageDto $pageDto)
    {
        return Page::query()->create($pageDto->toArray());
    }

    public function update(Page $page, PageDto $pageDto)
    {
        if (!$page->update($pageDto->toArray())) {
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
