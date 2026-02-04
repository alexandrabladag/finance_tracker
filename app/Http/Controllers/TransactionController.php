<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $month = Carbon::now();

        $transactions = $user->transactions()
            ->with(['account:id,name', 'category:id,name'])
            ->forMonth($month)
            ->orderByDesc('transaction_date')
            ->get();

        return inertia('Transactions/Index', [
            'month' => $month->format('Y-m'),
            'transactions' => $transactions->map(fn ($t) => [
                'id' => $t->id,
                'date' => $t->transaction_date->format('Y-m-d'),
                'account' => $t->account->name,
                'category' => $t->category->name,
                'amount' => $t->amount,
                'type' => $t->type,
                'notes' => $t->notes,
            ]),
        ]);
    }

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
