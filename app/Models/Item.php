<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'code',
        'category_id',
        'location',
        'description',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function adjustStock($type, $quantity)
    {
        if ($type === 'in') {
            $this->increment('stock', $quantity);
        } elseif ($type === 'out') {
            $this->decrement('stock', $quantity);
        }
    }
}
