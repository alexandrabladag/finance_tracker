<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $month = Carbon::now();

        return Inertia::render('Dashboard', [
            'month' => $month->format('Y-m'),

            'accounts' => $user->accounts->map(fn ($account) => [
                'id' => $account->id,
                'name' => $account->name,
                'type' => $account->type,
                'balance' => $account->balance(),
            ]),

            'summary' => [
                'inflow' => $user->transactions()
                    ->forMonth($month)
                    ->where('type', 'inflow')
                    ->sum('amount'),

                'expense' => $user->transactions()
                    ->forMonth($month)
                    ->where('type', 'expense')
                    ->sum('amount'),
            ],

            'budgets' => $user->categories
                ->where('kind', 'expense')
                ->map(fn ($category) =>
                    $category->budgetSummaryForMonth($month)
                )
                ->values(),
        ]);
    }
}
