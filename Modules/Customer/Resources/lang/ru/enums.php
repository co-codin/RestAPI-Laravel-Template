<?php


use Modules\Customer\Enums\CustomerGeographyType;
use Modules\Customer\Enums\District;
use Modules\Customer\Enums\CustomerType;

return [
    CustomerType::class => [
        CustomerType::State => 'Гос',
        CustomerType::PrivatePerson => 'Частное лицо',
        CustomerType::PrivateCenter => 'Частный центр',
    ],

    CustomerGeographyType::class => [
        CustomerGeographyType::State => 'Гос',
        CustomerGeographyType::PrivatePerson => 'Физ. лицо',
        CustomerGeographyType::PrivateCenter => 'Частный',
        CustomerGeographyType::Dealer => 'Дилер',
        CustomerGeographyType::DealerAndState => 'Дилер / Гос',
        CustomerGeographyType::DealerAndCenter => 'Дилер / Частный',
    ],

    District::class => [
        District::Central => 'Центральный',
        District::NorthWest => 'Северо-Западный',
        District::South => 'Южный',
        District::NorthCaucasian => 'Северо-Кавказский',
        District::Volga => 'Приволжский',
        District::Ural => 'Уральский',
        District::Siberian => 'Сибирский',
        District::FarEastern => 'Дальневосточный',
    ],
];
