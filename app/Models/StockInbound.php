<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class StockInbound extends Model
{
    use LogsActivity;
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

    public function mutation()
    {
        return $this->morphOne(StockMutation::class, 'reference');
    }

    protected static function booted()
    {
        // Automatically adjust product stock on creation
        static::created(function ($stockInbound) {
            $product = $stockInbound->product;
            if ($product) {
                $qty = (int) $stockInbound->quantity;
                $oldStock = (int) $product->stock;
                $newStock = $oldStock + $qty;
                $product->increment('stock', $qty);
                if (!$product->is_consignment) {
                    $product->update(['cost_price' => $stockInbound->cost_price]);
                }

                // Log stock mutation
                $stockInbound->mutation()->create([
                    'product_id' => $stockInbound->product_id,
                    'user_id' => $stockInbound->user_id ?? auth()->id(),
                    'type' => 'inbound',
                    'quantity_before' => $oldStock,
                    'quantity_change' => $qty,
                    'quantity_after' => $newStock,
                    'notes' => $stockInbound->notes ?? 'Stok Masuk (Supplier: ' . ($stockInbound->supplier ?? '-') . ')',
                ]);
            }
        });

        // Automatically adjust product stock on update
        static::updated(function ($stockInbound) {
            $product = $stockInbound->product;
            if ($product) {
                $qty = (int) $stockInbound->quantity;
                $oldQty = (int) $stockInbound->getOriginal('quantity');
                $diff = $qty - $oldQty;
                if ($diff !== 0) {
                    $product->increment('stock', $diff);
                }
                
                if (!$product->is_consignment && $stockInbound->cost_price !== $stockInbound->getOriginal('cost_price')) {
                    $product->update(['cost_price' => $stockInbound->cost_price]);
                }

                // Update stock mutation
                $mutation = $stockInbound->mutation;
                if ($mutation) {
                    $mutation->update([
                        'quantity_change' => $qty,
                        'quantity_after' => $mutation->quantity_before + $qty,
                        'user_id' => $stockInbound->user_id ?? auth()->id(),
                        'notes' => $stockInbound->notes ?? 'Stok Masuk (Supplier: ' . ($stockInbound->supplier ?? '-') . ')',
                    ]);
                }
            }
        });

        // Automatically reduce product stock on deletion
        static::deleted(function ($stockInbound) {
            $product = $stockInbound->product;
            if ($product) {
                $product->decrement('stock', (int) $stockInbound->quantity);

                // Delete stock mutation
                $stockInbound->mutation()->delete();
            }
        });
    }
}
