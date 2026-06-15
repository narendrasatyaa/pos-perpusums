<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    // Konvensi Laravel: boot[NamaTrait] otomatis dijalankan saat model di-boot
    public static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            self::logActivity('create', $model, null, $model->getAttributes());
        });

        static::updated(function (Model $model) {
            // Hanya mencatat log jika ada kolom yang benar-benar berubah
            $dirty = $model->getDirty();
            if (empty($dirty)) {
                return;
            }

            // Ambil nilai sebelum dan sesudah perubahan
            $old = array_intersect_key($model->getOriginal(), $dirty);
            $new = $dirty;

            // Jangan mencatat perubahan password demi keamanan
            unset($old['password'], $new['password']);

            self::logActivity('update', $model, $old, $new);
        });

        static::deleted(function (Model $model) {
            self::logActivity('delete', $model, $model->getAttributes(), null);
        });
    }

    protected static function logActivity(string $action, Model $model, ?array $old, ?array $new)
    {
        $module = class_basename($model);
        $description = self::getActivityDescription($action, $model);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'module' => $module,
            'model_id' => $model->getKey(),
            'description' => $description,
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()->ip(),
        ]);
    }

    protected static function getActivityDescription(string $action, Model $model): string
    {
        $module = class_basename($model);
        $name = '';

        if ($model instanceof \App\Models\StockInbound || $model instanceof \App\Models\StockAdjustment) {
            $productName = $model->product?->name ?? 'Produk';
            $qty = $model->quantity;
            if ($model instanceof \App\Models\StockAdjustment) {
                $type = $model->getTypeLabel();
                $name = "{$qty} pcs {$productName} ({$type})";
            } else {
                $name = "{$qty} pcs {$productName}";
            }
        } elseif ($model instanceof \App\Models\Transaction) {
            $name = "No. Order: {$model->order_code}";
        } else {
            $name = $model->name ?? $model->title ?? $model->id;
        }

        switch ($action) {
            case 'create':
                return "Membuat {$module} baru: '{$name}'";
            case 'update':
                return "Mengubah data {$module}: '{$name}'";
            case 'delete':
                return "Menghapus {$module}: '{$name}'";
            default:
                return "Melakukan {$action} pada {$module}";
        }
    }
}
