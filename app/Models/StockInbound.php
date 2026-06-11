<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInbound extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'received_at' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        // Automatically adjust product stock on creation
        static::created(function ($stockInbound) {
            $product = $stockInbound->product;
            if ($product) {
                $product->increment('stock', (int) $stockInbound->quantity);
                if (!$product->is_consignment) {
                    $product->update(['cost_price' => $stockInbound->cost_price]);
                }
            }
        });

        // Automatically adjust product stock on update
        static::updated(function ($stockInbound) {
            $product = $stockInbound->product;
            if ($product) {
                $diff = (int) $stockInbound->quantity - (int) $stockInbound->getOriginal('quantity');
                if ($diff !== 0) {
                    $product->increment('stock', $diff);
                }
                
                if (!$product->is_consignment && $stockInbound->cost_price !== $stockInbound->getOriginal('cost_price')) {
                    $product->update(['cost_price' => $stockInbound->cost_price]);
                }
            }
        });

        // Automatically reduce product stock on deletion
        static::deleted(function ($stockInbound) {
            $product = $stockInbound->product;
            if ($product) {
                $product->decrement('stock', (int) $stockInbound->quantity);
            }
        });
    }
}
