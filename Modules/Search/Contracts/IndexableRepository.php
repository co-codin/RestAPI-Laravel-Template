<?php

namespace Modules\Search\Contracts;

interface IndexableRepository
{
    public function getItemsToIndex();
}
