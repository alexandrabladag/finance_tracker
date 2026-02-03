<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'demo@financetracker.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            AccountSeeder::class,
            CategorySeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
