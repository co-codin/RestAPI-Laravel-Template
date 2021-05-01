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
            ->count(300)
            ->hasProductVariants(2)
            ->create()
            ->each(function (Product $product) {
                $categories = Category::query()
                    ->inRandomOrder()
                    ->whereNotNull('parent_id')
                    ->limit(1)
                    ->get();

                $product->categories()->sync($categories->pluck('id')->mapWithKeys(function ($item, $key) {
                    return [$item => ['is_main' => $key ? 2 : 1]];
                }));

                foreach ($categories as $category)
                {
                    $values = $category->properties->mapWithKeys(function (Property $property) {
                        $propValues = collect(PropertiesTableSeeder::properties())->where('name', $property->name)->first()['values'];
                        $propValues[] = null;

                        return [
                            $property->id => [
                                'value' => Arr::random($propValues),
                            ]
                        ];
                    })->toArray();

                    $product->properties()->sync($values);
                }
            });

        DB::statement('UPDATE products SET is_in_home=:is_in_home WHERE RAND() LIMIT 15', [
            ':is_in_home' => true,
        ]);
    }
}
