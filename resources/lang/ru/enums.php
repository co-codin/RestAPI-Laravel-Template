<?php

use App\Enums\Status;

return [
    Status::class => [
        Status::ACTIVE => 'Отображается на сайте',
        Status::INACTIVE => 'Скрыто',
        Status::ONLY_URL => 'Доступно только по URL',
    ],
];
