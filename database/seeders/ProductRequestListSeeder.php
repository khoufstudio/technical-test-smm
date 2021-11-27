<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductRequestList;

class ProductRequestListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductRequestList::factory()->count(50)->create();
    }
}
