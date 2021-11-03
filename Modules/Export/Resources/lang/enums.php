<?php

use Modules\Export\Enum\ExportType;
use Modules\Export\Enum\ExportFrequency;

return [
    ExportType::class => [
        ExportType::AVITO => 'Авито',
        ExportType::GOOGLE_MERCHANT => 'Google',
        ExportType::FACEBOOK => 'Faceboook',
        ExportType::PULS_CEN => 'Puls Cen',
        ExportType::SATOM => 'Satom',
        ExportType::TIU => 'TIU',
    ],

    ExportFrequency::class => [
        ExportFrequency::MANUALLY => 'Ручную',
        ExportFrequency::EVERY_30_MINUTES => 'Каждый 30 минут',
        ExportFrequency::HOURLY => 'Каждый час',
        ExportFrequency::EVERY_3_HOURS => 'Каждый 3 часа',
        ExportFrequency::DAILY => 'Каждый день',
        ExportFrequency::WEEKLY => 'Каждую неделю',
    ],
];
