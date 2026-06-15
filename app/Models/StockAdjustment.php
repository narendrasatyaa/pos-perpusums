<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
class StockAdjustment extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'adjusted_at' => 'date',
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

    public function getSignedQuantity($qty = null, $type = null)
    {
        $qty = $qty ?? $this->quantity;
        $type = $type ?? $this->type;

        if (in_array($type, ['waste', 'damage', 'correction_sub'])) {
            return -abs((int) $qty);
        }
        return abs((int) $qty);
    }

    public function getTypeLabel()
    {
        return match ($this->type) {
            'waste' => 'Waste (Penyusutan)',
            'damage' => 'Barang Rusak',
            'correction_add' => 'Koreksi Tambah',
            'correction_sub' => 'Koreksi Kurang',
            default => $this->type,
        };
    }

    protected static function booted()
    {
        static::created(function ($adjustment) {
            $product = $adjustment->product;
            if ($product) {
                $change = $adjustment->getSignedQuantity();
                $oldStock = (int) $product->stock;
                $newStock = $oldStock + $change;
                $product->increment('stock', $change);

                // Create stock mutation log
                $adjustment->mutation()->create([
                    'product_id' => $adjustment->product_id,
                    'user_id' => $adjustment->user_id ?? auth()->id(),
                    'type' => 'adjustment',
                    'quantity_before' => $oldStock,
                    'quantity_change' => $change,
                    'quantity_after' => $newStock,
                    'notes' => $adjustment->notes ?? 'Penyesuaian Stok (' . $adjustment->getTypeLabel() . ')',
                ]);
            }
        });

        static::updated(function ($adjustment) {
            $product = $adjustment->product;
            if ($product) {
                $oldChange = $adjustment->getSignedQuantity($adjustment->getOriginal('quantity'), $adjustment->getOriginal('type'));
                $newChange = $adjustment->getSignedQuantity();
                $diff = $newChange - $oldChange;

                if ($diff !== 0) {
                    $product->increment('stock', $diff);
                }

                // Update stock mutation
                $mutation = $adjustment->mutation;
                if ($mutation) {
                    $mutation->update([
                        'quantity_change' => $newChange,
                        'quantity_after' => $mutation->quantity_before + $newChange,
                        'user_id' => $adjustment->user_id ?? auth()->id(),
                        'notes' => $adjustment->notes ?? 'Penyesuaian Stok (' . $adjustment->getTypeLabel() . ')',
                    ]);
                }
            }
        });

        static::deleted(function ($adjustment) {
            $product = $adjustment->product;
            if ($product) {
                $change = $adjustment->getSignedQuantity();
                // Reverse the stock increment/decrement
                $product->decrement('stock', $change);

                // Delete the stock mutation
                $adjustment->mutation()->delete();
            }
        });
    }
}
