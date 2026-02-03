<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $accounts = [
            ['name' => 'Personal Cash', 'type' => 'personal', 'opening_balance' => 5000],
            ['name' => 'Bank Account', 'type' => 'personal', 'opening_balance' => 25000],
            ['name' => 'Travel Fund', 'type' => 'travel', 'opening_balance' => 10000],
        ];

        foreach ($accounts as $data) {
            Account::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $data['name'],
                ],
                [
                    'type' => $data['type'],
                    'opening_balance' => $data['opening_balance'],
                ]
            );
        }
    }
}
