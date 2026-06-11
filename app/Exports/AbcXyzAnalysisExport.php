<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class AbcXyzAnalysisExport implements FromQuery, WithHeadings, WithMapping
{
    protected Builder $query;
    protected array $analysis;
    protected string $startDate;
    protected string $endDate;

    public function __construct(Builder $query, array $analysis, string $startDate, string $endDate)
    {
        $this->query = clone $query;
        $this->analysis = $analysis;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Nama Produk',
            'Kategori',
            'Stok Saat Ini',
            'Satuan',
            'Total Omzet (' . $this->startDate . ' s/d ' . $this->endDate . ')',
            'Qty Terjual',
            'Kategori ABC',
            'Kategori XYZ',
            'Klasifikasi Kombinasi',
            'Rekomendasi Kebijakan',
        ];
    }

    /**
     * @param \App\Models\Product $product
     */
    public function map($product): array
    {
        $pId = (string) $product->id;
        $pData = $this->analysis[$pId] ?? ['abc' => 'C', 'xyz' => 'Z', 'revenue' => 0, 'quantity' => 0];

        $class = $pData['abc'] . $pData['xyz'];

        $recommendation = match ($class) {
            'AX' => 'Prioritas Utama: Kontrol stok ketat, safety stock rendah, reorder otomatis.',
            'AY' => 'Prioritas Utama: Kontrol stok ketat, safety stock sedang karena fluktuatif.',
            'AZ' => 'Prioritas Tinggi: Kontrol ketat, safety stock tinggi karena sangat sporadis.',
            'BX' => 'Prioritas Sedang: Kontrol berkala, order otomatis dengan safety stock rendah.',
            'BY' => 'Prioritas Sedang: Kontrol berkala, safety stock sedang.',
            'BZ' => 'Prioritas Sedang: Cek berkala, safety stock tinggi karena sporadis.',
            'CX' => 'Prioritas Rendah: Kontrol longgar, order dalam jumlah besar untuk kurangi ongkir.',
            'CY' => 'Prioritas Rendah: Kontrol longgar, sesuaikan dengan musim.',
            'CZ' => 'Prioritas Terendah: Just-In-Time (order hanya jika habis/ada pesanan), kurangi stok.',
            default => 'Kategori tidak dikenal.',
        };

        return [
            $product->sku,
            $product->name,
            $product->category?->name ?? '-',
            $product->stock,
            $product->unit ?? 'unit',
            'Rp ' . number_format($pData['revenue'], 0, ',', '.'),
            $pData['quantity'],
            $pData['abc'],
            $pData['xyz'],
            $class,
            $recommendation,
        ];
    }
}
