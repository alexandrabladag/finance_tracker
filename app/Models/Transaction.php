<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'amount',
        'type',
        'transaction_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeForMonth(Builder $query, Carbon $month): Builder
    {
        return $query->whereBetween(
            'transaction_date',
            [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ]
        );
    }


}
