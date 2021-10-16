<?php

namespace Modules\Geo\Database\Seeders\Data;

class GeoData
{
    public static function getCityData(): array
    {
        return [
            [
                'region' => "г. Санкт-Петербург",
                'name' => 'Санкт-Петербург',
                'coordinate' => [
                    'lat' => 59.936600,
                    'long' => 30.412800,
                ],
            ],
            [
                'region' => "Астраханская обл.",
                'name' => 'Астрахань',
                'coordinate' => [
                    'lat' => 46.319500,
                    'long' => 48.049500,
                ],
            ],
            [
                'region' => "г. Москва",
                'name' => 'Москва',
                'coordinate' => [
                    'lat' => 55.759000,
                    'long' => 37.635000,
                ],
            ],
            [
                'region' => "Калининградская обл.",
                'name' => 'Калининград',
                'coordinate' => [
                    'lat' => 54.708500,
                    'long' => 20.550500,
                ],
            ]
        ];
    }

    public static function getRegionData(): array
    {
        return array(
            0 =>
                array(
                    'name' => 'Адыгея',
                    'name_with_type' => 'Респ. Адыгея',
                    'federal_district' => 3,
                    'iso_code' => 'RU-AD',
                ),
            1 =>
                array(
                    'name' => 'Башкортостан',
                    'name_with_type' => 'Респ. Башкортостан',
                    'federal_district' => 5,
                    'iso_code' => 'RU-BA',
                ),
            2 =>
                array(
                    'name' => 'Бурятия',
                    'name_with_type' => 'Респ. Бурятия',
                    'federal_district' => 8,
                    'iso_code' => 'RU-BU',
                ),
            3 =>
                array(
                    'name' => 'Алтай',
                    'name_with_type' => 'Респ. Алтай',
                    'federal_district' => 7,
                    'iso_code' => 'RU-AL',
                ),
            4 =>
                array(
                    'name' => 'Дагестан',
                    'name_with_type' => 'Респ. Дагестан',
                    'federal_district' => 4,
                    'iso_code' => 'RU-DA',
                ),
            5 =>
                array(
                    'name' => 'Ингушетия',
                    'name_with_type' => 'Респ. Ингушетия',
                    'federal_district' => 4,
                    'iso_code' => 'RU-IN',
                ),
            6 =>
                array(
                    'name' => 'Кабардино-Балкарская',
                    'name_with_type' => 'Респ. Кабардино-Балкарская',
                    'federal_district' => 4,
                    'iso_code' => 'RU-KB',
                ),
            7 =>
                array(
                    'name' => 'Калмыкия',
                    'name_with_type' => 'Респ. Калмыкия',
                    'federal_district' => 3,
                    'iso_code' => 'RU-KL',
                ),
            8 =>
                array(
                    'name' => 'Карачаево-Черкесская',
                    'name_with_type' => 'Респ. Карачаево-Черкесская',
                    'federal_district' => 4,
                    'iso_code' => 'RU-KC',
                ),
            9 =>
                array(
                    'name' => 'Карелия',
                    'name_with_type' => 'Респ. Карелия',
                    'federal_district' => 2,
                    'iso_code' => 'RU-KR',
                ),
            10 =>
                array(
                    'name' => 'Коми',
                    'name_with_type' => 'Респ. Коми',
                    'federal_district' => 2,
                    'iso_code' => 'RU-KO',
                ),
            11 =>
                array(
                    'name' => 'Марий Эл',
                    'name_with_type' => 'Респ. Марий Эл',
                    'federal_district' => 5,
                    'iso_code' => 'RU-ME',
                ),
            12 =>
                array(
                    'name' => 'Мордовия',
                    'name_with_type' => 'Респ. Мордовия',
                    'federal_district' => 5,
                    'iso_code' => 'RU-MO',
                ),
            13 =>
                array(
                    'name' => 'Саха /Якутия/',
                    'name_with_type' => 'Респ. Саха /Якутия/',
                    'federal_district' => 8,
                    'iso_code' => 'RU-SA',
                ),
            14 =>
                array(
                    'name' => 'Северная Осетия - Алания',
                    'name_with_type' => 'Респ. Северная Осетия - Алания',
                    'federal_district' => 4,
                    'iso_code' => 'RU-SE',
                ),
            15 =>
                array(
                    'name' => 'Татарстан',
                    'name_with_type' => 'Респ. Татарстан',
                    'federal_district' => 5,
                    'iso_code' => 'RU-TA',
                ),
            16 =>
                array(
                    'name' => 'Тыва',
                    'name_with_type' => 'Респ. Тыва',
                    'federal_district' => 7,
                    'iso_code' => 'RU-TY',
                ),
            17 =>
                array(
                    'name' => 'Удмуртская',
                    'name_with_type' => 'Респ. Удмуртская',
                    'federal_district' => 5,
                    'iso_code' => 'RU-UD',
                ),
            18 =>
                array(
                    'name' => 'Хакасия',
                    'name_with_type' => 'Респ. Хакасия',
                    'federal_district' => 7,
                    'iso_code' => 'RU-KK',
                ),
            19 =>
                array(
                    'name' => 'Чеченская',
                    'name_with_type' => 'Респ. Чеченская',
                    'federal_district' => 4,
                    'iso_code' => 'RU-CE',
                ),
            20 =>
                array(
                    'name' => 'Чувашская Республика',
                    'name_with_type' => 'Чувашская Республика - Чувашия',
                    'federal_district' => 5,
                    'iso_code' => 'RU-CU',
                ),
            21 =>
                array(
                    'name' => 'Алтайский',
                    'name_with_type' => 'Алтайский край',
                    'federal_district' => 7,
                    'iso_code' => 'RU-ALT',
                ),
            22 =>
                array(
                    'name' => 'Краснодарский',
                    'name_with_type' => 'Краснодарский край',
                    'federal_district' => 3,
                    'iso_code' => 'RU-KDA',
                ),
            23 =>
                array(
                    'name' => 'Красноярский',
                    'name_with_type' => 'Красноярский край',
                    'federal_district' => 7,
                    'iso_code' => 'RU-KYA',
                ),
            24 =>
                array(
                    'name' => 'Приморский',
                    'name_with_type' => 'Приморский край',
                    'federal_district' => 8,
                    'iso_code' => 'RU-PRI',
                ),
            25 =>
                array(
                    'name' => 'Ставропольский',
                    'name_with_type' => 'Ставропольский край',
                    'federal_district' => 4,
                    'iso_code' => 'RU-STA',
                ),
            26 =>
                array(
                    'name' => 'Хабаровский',
                    'name_with_type' => 'Хабаровский край',
                    'federal_district' => 8,
                    'iso_code' => 'RU-KHA',
                ),
            27 =>
                array(
                    'name' => 'Амурская',
                    'name_with_type' => 'Амурская обл.',
                    'federal_district' => 8,
                    'iso_code' => 'RU-AMU',
                ),
            28 =>
                array(
                    'name' => 'Архангельская',
                    'name_with_type' => 'Архангельская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-ARK',
                ),
            29 =>
                array(
                    'name' => 'Астраханская',
                    'name_with_type' => 'Астраханская обл.',
                    'federal_district' => 3,
                    'iso_code' => 'RU-AST',
                ),
            30 =>
                array(
                    'name' => 'Белгородская',
                    'name_with_type' => 'Белгородская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-BEL',
                ),
            31 =>
                array(
                    'name' => 'Брянская',
                    'name_with_type' => 'Брянская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-BRY',
                ),
            32 =>
                array(
                    'name' => 'Владимирская',
                    'name_with_type' => 'Владимирская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-VLA',
                ),
            33 =>
                array(
                    'name' => 'Волгоградская',
                    'name_with_type' => 'Волгоградская обл.',
                    'federal_district' => 3,
                    'iso_code' => 'RU-VGG',
                ),
            34 =>
                array(
                    'name' => 'Вологодская',
                    'name_with_type' => 'Вологодская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-VLG',
                ),
            35 =>
                array(
                    'name' => 'Воронежская',
                    'name_with_type' => 'Воронежская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-VOR',
                ),
            36 =>
                array(
                    'name' => 'Ивановская',
                    'name_with_type' => 'Ивановская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-IVA',
                ),
            37 =>
                array(
                    'name' => 'Иркутская',
                    'name_with_type' => 'Иркутская обл.',
                    'federal_district' => 7,
                    'iso_code' => 'RU-IRK',
                ),
            38 =>
                array(
                    'name' => 'Калининградская',
                    'name_with_type' => 'Калининградская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-KGD',
                ),
            39 =>
                array(
                    'name' => 'Калужская',
                    'name_with_type' => 'Калужская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-KLU',
                ),
            40 =>
                array(
                    'name' => 'Камчатский',
                    'name_with_type' => 'Камчатский край',
                    'federal_district' => 8,
                    'iso_code' => 'RU-KAM',
                ),
            41 =>
                array(
                    'name' => 'Кемеровская область - Кузбасс',
                    'name_with_type' => 'Кемеровская область - Кузбасс обл.',
                    'federal_district' => 7,
                    'iso_code' => 'RU-KEM',
                ),
            42 =>
                array(
                    'name' => 'Кировская',
                    'name_with_type' => 'Кировская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-KIR',
                ),
            43 =>
                array(
                    'name' => 'Костромская',
                    'name_with_type' => 'Костромская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-KOS',
                ),
            44 =>
                array(
                    'name' => 'Курганская',
                    'name_with_type' => 'Курганская обл.',
                    'federal_district' => 6,
                    'iso_code' => 'RU-KGN',
                ),
            45 =>
                array(
                    'name' => 'Курская',
                    'name_with_type' => 'Курская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-KRS',
                ),
            46 =>
                array(
                    'name' => 'Ленинградская',
                    'name_with_type' => 'Ленинградская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-LEN',
                ),
            47 =>
                array(
                    'name' => 'Липецкая',
                    'name_with_type' => 'Липецкая обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-LIP',
                ),
            48 =>
                array(
                    'name' => 'Магаданская',
                    'name_with_type' => 'Магаданская обл.',
                    'federal_district' => 8,
                    'iso_code' => 'RU-MAG',
                ),
            49 =>
                array(
                    'name' => 'Московская',
                    'name_with_type' => 'Московская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-MOS',
                ),
            50 =>
                array(
                    'name' => 'Мурманская',
                    'name_with_type' => 'Мурманская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-MUR',
                ),
            51 =>
                array(
                    'name' => 'Нижегородская',
                    'name_with_type' => 'Нижегородская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-NIZ',
                ),
            52 =>
                array(
                    'name' => 'Новгородская',
                    'name_with_type' => 'Новгородская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-NGR',
                ),
            53 =>
                array(
                    'name' => 'Новосибирская',
                    'name_with_type' => 'Новосибирская обл.',
                    'federal_district' => 7,
                    'iso_code' => 'RU-NVS',
                ),
            54 =>
                array(
                    'name' => 'Омская',
                    'name_with_type' => 'Омская обл.',
                    'federal_district' => 7,
                    'iso_code' => 'RU-OMS',
                ),
            55 =>
                array(
                    'name' => 'Оренбургская',
                    'name_with_type' => 'Оренбургская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-ORE',
                ),
            56 =>
                array(
                    'name' => 'Орловская',
                    'name_with_type' => 'Орловская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-ORL',
                ),
            57 =>
                array(
                    'name' => 'Пензенская',
                    'name_with_type' => 'Пензенская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-PNZ',
                ),
            58 =>
                array(
                    'name' => 'Пермский',
                    'name_with_type' => 'Пермский край',
                    'federal_district' => 5,
                    'iso_code' => 'RU-PER',
                ),
            59 =>
                array(
                    'name' => 'Псковская',
                    'name_with_type' => 'Псковская обл.',
                    'federal_district' => 2,
                    'iso_code' => 'RU-PSK',
                ),
            60 =>
                array(
                    'name' => 'Ростовская',
                    'name_with_type' => 'Ростовская обл.',
                    'federal_district' => 3,
                    'iso_code' => 'RU-ROS',
                ),
            61 =>
                array(
                    'name' => 'Рязанская',
                    'name_with_type' => 'Рязанская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-RYA',
                ),
            62 =>
                array(
                    'name' => 'Самарская',
                    'name_with_type' => 'Самарская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-SAM',
                ),
            63 =>
                array(
                    'name' => 'Саратовская',
                    'name_with_type' => 'Саратовская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-SAR',
                ),
            64 =>
                array(
                    'name' => 'Сахалинская',
                    'name_with_type' => 'Сахалинская обл.',
                    'federal_district' => 8,
                    'iso_code' => 'RU-SAK',
                ),
            65 =>
                array(
                    'name' => 'Свердловская',
                    'name_with_type' => 'Свердловская обл.',
                    'federal_district' => 6,
                    'iso_code' => 'RU-SVE',
                ),
            66 =>
                array(
                    'name' => 'Смоленская',
                    'name_with_type' => 'Смоленская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-SMO',
                ),
            67 =>
                array(
                    'name' => 'Тамбовская',
                    'name_with_type' => 'Тамбовская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-TAM',
                ),
            68 =>
                array(
                    'name' => 'Тверская',
                    'name_with_type' => 'Тверская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-TVE',
                ),
            69 =>
                array(
                    'name' => 'Томская',
                    'name_with_type' => 'Томская обл.',
                    'federal_district' => 7,
                    'iso_code' => 'RU-TOM',
                ),
            70 =>
                array(
                    'name' => 'Тульская',
                    'name_with_type' => 'Тульская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-TUL',
                ),
            71 =>
                array(
                    'name' => 'Тюменская',
                    'name_with_type' => 'Тюменская обл.',
                    'federal_district' => 6,
                    'iso_code' => 'RU-TYU',
                ),
            72 =>
                array(
                    'name' => 'Ульяновская',
                    'name_with_type' => 'Ульяновская обл.',
                    'federal_district' => 5,
                    'iso_code' => 'RU-ULY',
                ),
            73 =>
                array(
                    'name' => 'Челябинская',
                    'name_with_type' => 'Челябинская обл.',
                    'federal_district' => 6,
                    'iso_code' => 'RU-CHE',
                ),
            74 =>
                array(
                    'name' => 'Забайкальский',
                    'name_with_type' => 'Забайкальский край',
                    'federal_district' => 8,
                    'iso_code' => 'RU-ZAB',
                ),
            75 =>
                array(
                    'name' => 'Ярославская',
                    'name_with_type' => 'Ярославская обл.',
                    'federal_district' => 1,
                    'iso_code' => 'RU-YAR',
                ),
            76 =>
                array(
                    'name' => 'Москва',
                    'name_with_type' => 'г. Москва',
                    'federal_district' => 1,
                    'iso_code' => 'RU-MOW',
                ),
            77 =>
                array(
                    'name' => 'Санкт-Петербург',
                    'name_with_type' => 'г. Санкт-Петербург',
                    'federal_district' => 2,
                    'iso_code' => 'RU-SPE',
                ),
            78 =>
                array(
                    'name' => 'Еврейская',
                    'name_with_type' => 'Еврейская Аобл.',
                    'federal_district' => 8,
                    'iso_code' => 'RU-YEV',
                ),
            79 =>
                array(
                    'name' => 'Ненецкий',
                    'name_with_type' => 'Ненецкий АО',
                    'federal_district' => 2,
                    'iso_code' => 'RU-NEN',
                ),
            80 =>
                array(
                    'name' => 'Ханты-Мансийский Автономный округ - Югра',
                    'name_with_type' => 'Ханты-Мансийский Автономный округ - Югра АО',
                    'federal_district' => 6,
                    'iso_code' => 'RU-KHM',
                ),
            81 =>
                array(
                    'name' => 'Чукотский',
                    'name_with_type' => 'Чукотский АО',
                    'federal_district' => 8,
                    'iso_code' => 'RU-CHU',
                ),
            82 =>
                array(
                    'name' => 'Ямало-Ненецкий',
                    'name_with_type' => 'Ямало-Ненецкий АО',
                    'federal_district' => 6,
                    'iso_code' => 'RU-YAN',
                ),
            83 =>
                array(
                    'name' => 'Крым',
                    'name_with_type' => 'Респ. Крым',
                    'federal_district' => 3,
                    'iso_code' => 'UA-43',
                ),
            84 =>
                array(
                    'name' => 'Севастополь',
                    'name_with_type' => 'г. Севастополь',
                    'federal_district' => 3,
                    'iso_code' => 'UA-40',
                ),
        );
    }
}
