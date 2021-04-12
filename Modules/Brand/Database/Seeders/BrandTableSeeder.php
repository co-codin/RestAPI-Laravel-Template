<?php

namespace Modules\Brand\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Models\Brand;

class BrandTableSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Mindray', 'image' => "/uploads/test/brands/mindray.jpg", "is_in_home" => true],
            ['name' => 'Aohua', 'image' => "/uploads/test/brands/aohua.jpg", "is_in_home" => true],
            ['name' => 'Heinen + Lowenstein', 'image' => "/uploads/test/brands/heinen-lowenstein.jpg", "is_in_home" => true],
            ['name' => 'Samsung', 'image' => "/uploads/test/brands/samsung.jpg", "is_in_home" => true],
            ['name' => 'Pentax', 'image' => "/uploads/test/brands/pentax.jpg", "is_in_home" => true],
            ['name' => 'Maquet', 'image' => "/uploads/test/brands/maquet.jpg", "is_in_home" => true],
            ['name' => 'GE', 'image' => "/uploads/test/brands/ge.jpg", "is_in_home" => true],
            ['name' => 'SonoScape', 'image' => "/uploads/test/brands/sonoscape.jpg", "is_in_home" => true],
            ['name' => 'Chirana', 'image' => "/uploads/test/brands/chirana.jpg", "is_in_home" => true],
            ['name' => 'Philips', 'image' => "/uploads/test/brands/philips.jpg", "is_in_home" => true],
            ['name' => 'Dixion', 'image' => "/uploads/test/brands/dixion.jpg", "is_in_home" => true],
            ['name' => 'Drager', 'image' => "/uploads/test/brands/drager.jpg", "is_in_home" => true],
            ['name' => 'Toshiba', 'image' => "/uploads/test/brands/toshiba.jpg", "is_in_home" => true],
            ['name' => 'Medstar', 'image' => "/uploads/test/brands/medstar.jpg", "is_in_home" => true],
            ['name' => 'Heinemann', 'image' => "/uploads/test/brands/heinemann.jpg", "is_in_home" => true],
            ['name' => 'Hitachi-Aloka', 'image' => "/uploads/test/brands/hitachi-aloka.jpg", "is_in_home" => true],
            ['name' => 'Amg Азимут', 'image' => "/uploads/test/brands/amg-azimut.jpg", "is_in_home" => true],
            ['name' => 'MS Westfalia', 'image' => "/uploads/test/brands/ms-westfalia.jpg", "is_in_home" => true],
            ['name' => 'Fujifilm', 'image' => "/uploads/test/brands/fujifilm.jpg", "is_in_home" => true],
            ['name' => 'Atmos', 'image' => "/uploads/test/brands/atmos.jpg", "is_in_home" => true],
            ['name' => 'Zerts', 'image' => "/uploads/test/brands/zerts.jpg", "is_in_home" => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
