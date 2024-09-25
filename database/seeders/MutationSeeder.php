<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Mutation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            $this->call(UserSeeder::class);
        }

        if (Item::count() == 0) {
            $this->call(ItemSeeder::class);
        }

        DB::transaction(function () {
            Mutation::factory()->count(30)->create()->each(function ($mutation) {
                $item = Item::find($mutation->item_id);

                if ($mutation->type === 'in') {
                    $item->increment('stock', $mutation->quantity);
                } else {
                    $item->decrement('stock', $mutation->quantity);
                }
            });
        });
    }
}
