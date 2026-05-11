<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new UserSeeder();
        $user->run();
        $categories = Category::factory(10)->create();

        $categories->each(function ($category) {
            Product::factory(fake()->numberBetween(5, 20))
                ->create(['category_id' => $category->id]);
        });

    }
}
