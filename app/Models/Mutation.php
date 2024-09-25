<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'date',
        'type',
        'quantity',
        'user_id',
        'item_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function adjustStock($type, $quantity)
    {
        if ($type === 'in') {
            $this->increment('stock', $quantity);
        } elseif ($type === 'out') {
            $this->decrement('stock', $quantity);
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
