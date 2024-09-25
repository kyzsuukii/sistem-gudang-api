<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() == 0) {
            $this->call(CategorySeeder::class);
        }

        Item::factory()->count(20)->create();
    }
}
