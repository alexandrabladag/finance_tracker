<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'opening_balance',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function balance(): float
    {
        $inflows = $this->transactions()
            ->where('type', 'inflow')
            ->sum('amount');

        $expenses = $this->transactions()
            ->where('type', 'expense')
            ->sum('amount');

        return (float) $this->opening_balance + $inflows - $expenses;
    }


}
