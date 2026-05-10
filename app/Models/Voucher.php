<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'discount_value' => 'integer',
            'max_discount' => 'integer',
            'min_purchase' => 'integer',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isCurrentlyValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if (!is_null($this->usage_limit) && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeAppliedToSubtotal(int $subtotal): bool
    {
        return $subtotal >= (int) ($this->min_purchase ?? 0);
    }

    public function hasValidDiscountConfiguration(): bool
    {
        $discountValue = (int) $this->discount_value;

        if ($discountValue < 1) {
            return false;
        }

        if ($this->discount_type === 'percent' && $discountValue > 100) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(int $subtotal): int
    {
        if ($subtotal <= 0) {
            return 0;
        }

        if (!$this->hasValidDiscountConfiguration()) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            $discount = (int) round($subtotal * ((int) $this->discount_value / 100));
        } else {
            $discount = (int) $this->discount_value;
        }

        if (!is_null($this->max_discount)) {
            $discount = min($discount, (int) $this->max_discount);
        }

        return max(0, min($discount, $subtotal));
    }
}
