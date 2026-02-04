<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'kind',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function actualForMonth(Carbon $month): float
    {
        return (float) $this->transactions()
            ->where('type', 'expense')
            ->whereBetween(
                'transaction_date',
                [
                    $month->copy()->startOfMonth(),
                    $month->copy()->endOfMonth(),
                ]
            )
            ->sum('amount');
    }

    public function budgetForMonth(Carbon $month): float
    {
        return (float) $this->budgets()
            ->whereDate('period_start', $month->copy()->startOfMonth())
            ->value('amount') ?? 0;
    }

    public function budgetSummaryForMonth(Carbon $month): array
    {
        $budget = $this->budgetForMonth($month);
        $actual = $this->actualForMonth($month);

        return [
            'category' => $this->name,
            'budget' => $budget,
            'actual' => $actual,
            'difference' => $budget - $actual,
            'status' => $actual > $budget ? 'over' : 'within',
        ];
    }

}
