<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerReviewsTableSeeder::class);
    }
}
