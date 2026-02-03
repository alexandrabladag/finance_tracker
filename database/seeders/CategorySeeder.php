<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $expenseParents = [
            'Utilities' => ['Electricity', 'Internet'],
            'Groceries' => [],
            'Transportation' => ['Fuel', 'Public Transport'],
            'Savings' => [],
        ];

        foreach ($expenseParents as $parentName => $children) {
            $parent = Category::firstOrCreate([
                'user_id' => $user->id,
                'name' => $parentName,
                'kind' => 'expense',
            ]);

            foreach ($children as $childName) {
                Category::firstOrCreate([
                    'user_id' => $user->id,
                    'parent_id' => $parent->id,
                    'name' => $childName,
                    'kind' => 'expense',
                ]);
            }
        }

        Category::firstOrCreate([
            'user_id' => $user->id,
            'name' => 'Income',
            'kind' => 'inflow',
        ]);
    }
}
