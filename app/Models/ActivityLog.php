<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $guarded = [];

    // Cast kolom JSON database agar otomatis terbaca sebagai array PHP
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // Relasi ke User yang melakukan aktivitas
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
