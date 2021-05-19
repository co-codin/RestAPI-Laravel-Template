<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Customer\Models\CustomerReview;

class CustomerReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerReview::factory()->times(50)->create([
            'is_home' => false
        ]);

        CustomerReview::factory()->times(50)->create();
    }
}
