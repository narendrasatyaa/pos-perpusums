<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

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
    ];
}
