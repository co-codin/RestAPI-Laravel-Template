<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;
use Modules\Property\Database\Seeders\PropertiesTableSeeder;
use Modules\Property\Models\Property;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(100)
//            ->hasProductVariations(2)
            ->create(['brand_id' => 1])
            ->each(function (Product $product) {
                $category = Category::query()->select('id')->inRandomOrder()->whereNotNull('parent_id')->first();

                $product->categories()->attach($category->id, ['is_main' => true]);

                $values = [];

                $properties = Property::query()
                    ->inRandomOrder()
                    ->take(10)
                    ->get();

                foreach ($properties as $property) {
                    $propertyValues = collect(PropertiesTableSeeder::properties())->where('name', $property->name)->first()['values'];
                    $values[$property->id] = [
                        'value' => Arr::random($propertyValues),
                    ];
                }

                $product->properties()->attach($values);
            });

        DB::statement('UPDATE products SET is_in_home=:is_in_home WHERE RAND() LIMIT 15', [
            ':is_in_home' => true,
        ]);
    }
}
