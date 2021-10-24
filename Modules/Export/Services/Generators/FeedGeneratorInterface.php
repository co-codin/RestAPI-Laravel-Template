<?php


namespace Modules\Export\Services\Generators;


use Illuminate\Database\Eloquent\Model;
use Modules\Export\Models\Export;

interface FeedGeneratorInterface
{
    public function generate(Model|Export $export): void;
}
