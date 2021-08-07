<?php

namespace Modules\Geo\Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\City;

class CityTableSeederTableSeeder extends Seeder
{
    public function run()
    {
        $regions = collect($this->getRegionData());

        $cities = collect($this->getCityData());

        $data = $cities->map(function ($city, $key) use ($regions) {
            $region = $regions->where('name_with_type', '=', $city['region'])->first();
            return collect($city)->merge(['region' => $region]);
        });

        foreach ($data->toArray() as $item) {
            $region = $item['region'];
            City::query()->create([
                'region_name' => $region['name'],
                'region_name_with_type' => $region['name_with_type'],
                'federal_district' =>  $region['federal_district'],
                'iso' => $region['iso'],

                'city_name' => $item['name'],
                'status' => Status::ACTIVE,
                'is_default' => $item['name'] === 'Москва' ? 1 : 2,
                'coordinate' => $item['coordinate'],
            ]);
        }
    }

    protected function getRegionData()
    {
        return [
            [
                "name" => "Адыгея",
                "name_with_type" => "Респ. Адыгея",
                "federal_district" => 1,
                "iso" => "RU-AD",
            ],
            [
                "name" => "Башкортостан",
                "name_with_type" => "Респ. Башкортостан",
                "federal_district" => 2,
                "iso" => "RU-BA",
            ],
            [
                "name" => "Бурятия",
                "name_with_type" => "Респ. Бурятия",
                "federal_district" => 3,
                "iso" => "RU-BU",
            ],
            [
                "name" => "Алтай",
                "name_with_type" => "Респ. Алтай",
                "federal_district" => 4,
                "iso" => "RU-AL",
            ],
            [
                "name" => "Дагестан",
                "name_with_type" => "Респ. Дагестан",
                "federal_district" => 5,
                "iso" => "RU-DA",
            ],
            [
                "name" => "Ингушетия",
                "name_with_type" => "Респ. Ингушетия",
                "federal_district" => 5,
                "iso" => "RU-IN",
            ],
            [
                "name" => "Кабардино-Балкарская",
                "name_with_type" => "Респ. Кабардино-Балкарская",
                "federal_district" => 5,
                "iso" => "RU-KB",
            ],
            [
                "name" => "Калмыкия",
                "name_with_type" => "Респ. Калмыкия",
                "federal_district" => 1,
                "iso" => "RU-KL",
            ],
            [
                "name" => "Карачаево-Черкесская",
                "name_with_type" => "Респ. Карачаево-Черкесская",
                "federal_district" => 5,
                "iso" => "RU-KC",
            ],
            [
                "name" => "Карелия",
                "name_with_type" => "Респ. Карелия",
                "federal_district" => 6,
                "iso" => "RU-KR",
            ],
            [
                "name" => "Коми",
                "name_with_type" => "Респ. Коми",
                "federal_district" => 6,
                "iso" => "RU-KO",
            ],
            [
                "name" => "Марий Эл",
                "name_with_type" => "Респ. Марий Эл",
                "federal_district" => 2,
                "iso" => "RU-ME",
            ],
            [
                "name" => "Мордовия",
                "name_with_type" => "Респ. Мордовия",
                "federal_district" => 2,
                "iso" => "RU-MO",
            ],
            [
                "name" => "Саха /Якутия/",
                "name_with_type" => "Респ. Саха /Якутия/",
                "federal_district" => 3,
                "iso" => "RU-SA",
            ],
            [
                "name" => "Северная Осетия - Алания",
                "name_with_type" => "Респ. Северная Осетия - Алания",
                "federal_district" => 5,
                "iso" => "RU-SE",
            ],
            [
                "name" => "Татарстан",
                "name_with_type" => "Респ. Татарстан",
                "federal_district" => 2,
                "iso" => "RU-TA",
            ],
            [
                "name" => "Тыва",
                "name_with_type" => "Респ. Тыва",
                "federal_district" => 4,
                "iso" => "RU-TY",
            ],
            [
                "name" => "Удмуртская",
                "name_with_type" => "Респ. Удмуртская",
                "federal_district" => 2,
                "iso" => "RU-UD",
            ],
            [
                "name" => "Хакасия",
                "name_with_type" => "Респ. Хакасия",
                "federal_district" => 4,
                "iso" => "RU-KK",
            ],
            [
                "name" => "Чеченская",
                "name_with_type" => "Респ. Чеченская",
                "federal_district" => 5,
                "iso" => "RU-CE",
            ],
            [
                "name" => "Чувашская Республика -",
                "name_with_type" => "Чувашская Республика - Чувашия",
                "federal_district" => 2,
                "iso" => "RU-CU",
            ],
            [
                "name" => "Алтайский",
                "name_with_type" => "Алтайский край",
                "federal_district" => 4,
                "iso" => "RU-ALT",
            ],
            [
                "name" => "Краснодарский",
                "name_with_type" => "Краснодарский край",
                "federal_district" => 1,
                "iso" => "RU-KDA",
            ],
            [
                "name" => "Красноярский",
                "name_with_type" => "Красноярский край",
                "federal_district" => 4,
                "iso" => "RU-KYA",
            ],
            [
                "name" => "Приморский",
                "name_with_type" => "Приморский край",
                "federal_district" => 3,
                "iso" => "RU-PRI",
            ],
            [
                "name" => "Ставропольский",
                "name_with_type" => "Ставропольский край",
                "federal_district" => 5,
                "iso" => "RU-STA",
            ],
            [
                "name" => "Хабаровский",
                "name_with_type" => "Хабаровский край",
                "federal_district" => 3,
                "iso" => "RU-KHA",
            ],
            [
                "name" => "Амурская",
                "name_with_type" => "Амурская обл.",
                "federal_district" => 3,
                "iso" => "RU-AMU",
            ],
            [
                "name" => "Архангельская",
                "name_with_type" => "Архангельская обл.",
                "federal_district" => 6,
                "iso" => "RU-ARK",
            ],
            [
                "name" => "Астраханская",
                "name_with_type" => "Астраханская обл.",
                "federal_district" => 1,
                "iso" => "RU-AST",
            ],
            [
                "name" => "Белгородская",
                "name_with_type" => "Белгородская обл.",
                "federal_district" => 7,
                "iso" => "RU-BEL",
            ],
            [
                "name" => "Брянская",
                "name_with_type" => "Брянская обл.",
                "federal_district" => 7,
                "iso" => "RU-BRY",
            ],
            [
                "name" => "Владимирская",
                "name_with_type" => "Владимирская обл.",
                "federal_district" => 7,
                "iso" => "RU-VLA",
            ],
            [
                "name" => "Волгоградская",
                "name_with_type" => "Волгоградская обл.",
                "federal_district" => 1,
                "iso" => "RU-VGG",
            ],
            [
                "name" => "Вологодская",
                "name_with_type" => "Вологодская обл.",
                "federal_district" => 6,
                "iso" => "RU-VLG",
            ],
            [
                "name" => "Воронежская",
                "name_with_type" => "Воронежская обл.",
                "federal_district" => 7,
                "iso" => "RU-VOR",
            ],
            [
                "name" => "Ивановская",
                "name_with_type" => "Ивановская обл.",
                "federal_district" => 7,
                "iso" => "RU-IVA",
            ],
            [
                "name" => "Иркутская",
                "name_with_type" => "Иркутская обл.",
                "federal_district" => 4,
                "iso" => "RU-IRK",
            ],
            [
                "name" => "Калининградская",
                "name_with_type" => "Калининградская обл.",
                "federal_district" => 6,
                "iso" => "RU-KGD",
            ],
            [
                "name" => "Калужская",
                "name_with_type" => "Калужская обл.",
                "federal_district" => 7,
                "iso" => "RU-KLU",
            ],
            [
                "name" => "Камчатский",
                "name_with_type" => "Камчатский край",
                "federal_district" => 3,
                "iso" => "RU-KAM",
            ],
            [
                "name" => "Кемеровская область - Кузбасс обл.",
                "name_with_type" => "Кемеровская область - Кузбасс обл.",
                "federal_district" => 4,
                "iso" => "RU-KEM",
            ],
            [
                "name" => "Кировская",
                "name_with_type" => "Кировская обл.",
                "federal_district" => 2,
                "iso" => "RU-KIR",
            ],
            [
                "name" => "Костромская",
                "name_with_type" => "Костромская обл.",
                "federal_district" => 7,
                "iso" => "RU-KOS",
            ],
            [
                "name" => "Курганская",
                "name_with_type" => "Курганская обл.",
                "federal_district" => 8,
                "iso" => "RU-KGN",
            ],
            [
                "name" => "Курская",
                "name_with_type" => "Курская обл.",
                "federal_district" => 7,
                "iso" => "RU-KRS",
            ],
            [
                "name" => "Ленинградская",
                "name_with_type" => "Ленинградская обл.",
                "federal_district" => 6,
                "iso" => "RU-LEN",
            ],
            [
                "name" => "Липецкая",
                "name_with_type" => "Липецкая обл.",
                "federal_district" => 7,
                "iso" => "RU-LIP",
            ],
            [
                "name" => "Магаданская",
                "name_with_type" => "Магаданская обл.",
                "federal_district" => 3,
                "iso" => "RU-MAG",
            ],
            [
                "name" => "Московская",
                "name_with_type" => "Московская обл.",
                "federal_district" => 7,
                "iso" => "RU-MOS",
            ],
            [
                "name" => "Мурманская",
                "name_with_type" => "Мурманская обл.",
                "federal_district" => 6,
                "iso" => "RU-MUR",
            ],
            [
                "name" => "Нижегородская",
                "name_with_type" => "Нижегородская обл.",
                "federal_district" => 2,
                "iso" => "RU-NIZ",
            ],
            [
                "name" => "Новгородская",
                "name_with_type" => "Новгородская обл.",
                "federal_district" => 6,
                "iso" => "RU-NGR",
            ],
            [
                "name" => "Новосибирская",
                "name_with_type" => "Новосибирская обл.",
                "federal_district" => 4,
                "iso" => "RU-NVS",
            ],
            [
                "name" => "Омская",
                "name_with_type" => "Омская обл.",
                "federal_district" => 4,
                "iso" => "RU-OMS",
            ],
            [
                "name" => "Оренбургская",
                "name_with_type" => "Оренбургская обл.",
                "federal_district" => 2,
                "iso" => "RU-ORE",
            ],
            [
                "name" => "Орловская",
                "name_with_type" => "Орловская обл.",
                "federal_district" => 7,
                "iso" => "RU-ORL",
            ],
            [
                "name" => "Пензенская",
                "name_with_type" => "Пензенская обл.",
                "federal_district" => 2,
                "iso" => "RU-PNZ",
            ],
            [
                "name" => "Пермский",
                "name_with_type" => "Пермский край",
                "federal_district" => 2,
                "iso" => "RU-PER",
            ],
            [
                "name" => "Псковская",
                "name_with_type" => "Псковская обл.",
                "federal_district" => 6,
                "iso" => "RU-PSK",
            ],
            [
                "name" => "Ростовская",
                "name_with_type" => "Ростовская обл.",
                "federal_district" => 1,
                "iso" => "RU-ROS",
            ],
            [
                "name" => "Рязанская",
                "name_with_type" => "Рязанская обл.",
                "federal_district" => 7,
                "iso" => "RU-RYA",
            ],
            [
                "name" => "Самарская",
                "name_with_type" => "Самарская обл.",
                "federal_district" => 2,
                "iso" => "RU-SAM",
            ],
            [
                "name" => "Саратовская",
                "name_with_type" => "Саратовская обл.",
                "federal_district" => 2,
                "iso" => "RU-SAR",
            ],
            [
                "name" => "Сахалинская",
                "name_with_type" => "Сахалинская обл.",
                "federal_district" => 3,
                "iso" => "RU-SAK",
            ],
            [
                "name" => "Свердловская",
                "name_with_type" => "Свердловская обл.",
                "federal_district" => 8,
                "iso" => "RU-SVE",
            ],
            [
                "name" => "Смоленская",
                "name_with_type" => "Смоленская обл.",
                "federal_district" => 7,
                "iso" => "RU-SMO",
            ],
            [
                "name" => "Тамбовская",
                "name_with_type" => "Тамбовская обл.",
                "federal_district" => 7,
                "iso" => "RU-TAM",
            ],
            [
                "name" => "Тверская",
                "name_with_type" => "Тверская обл.",
                "federal_district" => 7,
                "iso" => "RU-TVE",
            ],
            [
                "name" => "Томская",
                "name_with_type" => "Томская обл.",
                "federal_district" => 4,
                "iso" => "RU-TOM",
            ],
            [
                "name" => "Тульская",
                "name_with_type" => "Тульская обл.",
                "federal_district" => 7,
                "iso" => "RU-TUL",
            ],
            [
                "name" => "Тюменская",
                "name_with_type" => "Тюменская обл.",
                "federal_district" => 8,
                "iso" => "RU-TYU",
            ],
            [
                "name" => "Ульяновская",
                "name_with_type" => "Ульяновская обл.",
                "federal_district" => 2,
                "iso" => "RU-ULY",
            ],
            [
                "name" => "Челябинская",
                "name_with_type" => "Челябинская обл.",
                "federal_district" => 8,
                "iso" => "RU-CHE",
            ],
            [
                "name" => "Забайкальский",
                "name_with_type" => "Забайкальский край",
                "federal_district" => 3,
                "iso" => "RU-ZAB",
            ],
            [
                "name" => "Ярославская",
                "name_with_type" => "Ярославская обл.",
                "federal_district" => 7,
                "iso" => "RU-YAR",
            ],
            [
                "name" => "Москва",
                "name_with_type" => "г. Москва",
                "federal_district" => 7,
                "iso" => "RU-MOW",
            ],
            [
                "name" => "Санкт-Петербург",
                "name_with_type" => "г. Санкт-Петербург",
                "federal_district" => 6,
                "iso" => "RU-SPE",
            ],
            [
                "name" => "Еврейская",
                "name_with_type" => "Еврейская Аобл.",
                "federal_district" => 3,
                "iso" => "RU-YEV",
            ],
            [
                "name" => "Ненецкий",
                "name_with_type" => "Ненецкий АО",
                "federal_district" => 6,
                "iso" => "RU-NEN",
            ],
            [
                "name" => "Ханты-Мансийский Автономный округ - Югра АО",
                "name_with_type" => "Ханты-Мансийский Автономный округ - Югра АО",
                "federal_district" => 8,
                "iso" => "RU-KHM",
            ],
            [
                "name" => "Чукотский",
                "name_with_type" => "Чукотский АО",
                "federal_district" => 3,
                "iso" => "RU-CHU",
            ],
            [
                "name" => "Ямало-Ненецкий",
                "name_with_type" => "Ямало-Ненецкий АО",
                "federal_district" => 8,
                "iso" => "RU-YAN",
            ],
            [
                "name" => "Крым",
                "name_with_type" => "Респ. Крым",
                "federal_district" => 1,
                "iso" => "UA-43",
            ],
            [
                "name" => "Севастополь",
                "name_with_type" => "г. Севастополь",
                "federal_district" => 1,
                "iso" => "UA-40",
            ]
        ];
    }

    protected function getCityData()
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
}
