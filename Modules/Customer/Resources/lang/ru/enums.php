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
        District::Central => 'Центральный федеральный округ',
        District::NorthWest => 'Северо-Западный федеральный округ',
        District::South => 'Южный федеральный округ',
        District::NorthCaucasian => 'Северо-Кавказский федеральный округ',
        District::Volga => 'Приволжский федеральный округ',
        District::Ural => 'Уральский федеральный округ',
        District::Siberian => 'Сибирский федеральный округ',
        District::FarEastern => 'Дальневосточный федеральный округ',
    ],
];
