<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Transaction extends Model
{
    use LogsActivity;
    protected $guarded = [];

    protected $appends = [
        'transfer_proof_url',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     protected $casts = [
        'paid_at'       => 'datetime',
        'subtotal'      => 'integer',
        'total'         => 'integer',
        'paid_amount'   => 'integer',
        'change_amount' => 'integer',
        'discount_value' => 'integer',
        'payment_method' => 'string',
        'transfer_proof_path' => 'string',
        'payment_validation_status' => 'string',
    ];

    public function getTransferProofUrlAttribute(): ?string
    {
        if (blank($this->transfer_proof_path)) {
            return null;
        }

        return route('kasir.transfer-proofs.show', [
            'filename' => basename($this->transfer_proof_path),
        ]);
    }
}
