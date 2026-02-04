<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        return inertia('Transactions/Create', [
            'accounts' => $user->accounts()->get(['id', 'name']),
            'categories' => $user->categories()
                ->where('kind', 'expense')
                ->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        Transaction::create([
            'user_id' => $request->user()->id,
            'account_id' => $validated['account_id'],
            'category_id' => $validated['category_id'],
            'amount' => $validated['amount'],
            'type' => 'expense',
            'transaction_date' => Carbon::parse($validated['transaction_date']),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('dashboard');
    }
}
