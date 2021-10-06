<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Illuminate\Console\Command;

class MigrateFieldValue extends Command
{
    protected $signature = 'migrate:field-values';

    protected $description = 'Migrate default field values';

    protected $fieldValues = [
        ['value' => 'Да', 'slug' => 'yes'],
        ['value' => 'Нет', 'slug' => 'no'],
    ];

    public function handle()
    {
        foreach ($this->fieldValues as $fieldValue) {
            FieldValue::query()->create($fieldValue);
        }
    }
}
