<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $account = $user->accounts()->first();
        $category = $user->categories()->where('kind', 'expense')->first();

        Transaction::create([
            'user_id' => $user->id,
            'account_id' => $account->id,
            'category_id' => $category->id,
            'amount' => 1200,
            'type' => 'expense',
            'transaction_date' => Carbon::now()->subDays(3),
            'notes' => 'Sample grocery purchase',
        ]);
    }
}
