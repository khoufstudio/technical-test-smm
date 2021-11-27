<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductRequest;

class ProductRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductRequest::factory()->count(30)->create();
    }
}
