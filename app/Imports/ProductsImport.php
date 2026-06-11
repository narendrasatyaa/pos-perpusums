<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, SkipsEmptyRows, WithChunkReading, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        $items = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $data = Validator::make($row->toArray(), [
                'kategori' => ['required', 'string', 'max:255'],
                'nama' => ['required', 'string', 'max:255'],
                'harga' => ['required'],
                'stok' => ['required'],
                'tersedia' => ['required'],
                'hpp' => ['nullable'],
                'titipan' => ['nullable'],
                'tipe_bagi_hasil' => ['nullable'],
                'bagi_hasil_penitip' => ['nullable'],
            ])->validate();

            $categoryName = trim((string) $data['kategori']);
            $category = Category::query()
                ->whereRaw('LOWER(name) = ?', [mb_strtolower($categoryName)])
                ->first();

            if (! $category) {
                throw ValidationException::withMessages([
                    'kategori' => "Baris {$rowNumber}: kategori '{$categoryName}' belum ada di master kategori.",
                ]);
            }

            $isConsignment = isset($data['titipan']) ? $this->toBoolean($data['titipan']) : false;
            $consignorShareType = isset($data['tipe_bagi_hasil']) ? (trim(strtolower((string) $data['tipe_bagi_hasil'])) === 'nominal' ? 'nominal' : 'percent') : 'percent';
            $consignorShare = isset($data['bagi_hasil_penitip']) ? $this->toInteger($data['bagi_hasil_penitip']) : null;
            $costPrice = isset($data['hpp']) ? $this->toInteger($data['hpp']) : null;

            $items[] = [
                'category_id' => $category->id,
                'name' => trim((string) $data['nama']),
                'price' => $this->toInteger($data['harga']),
                'stock' => $this->toInteger($data['stok']),
                'is_available' => $this->toBoolean($data['tersedia']),
                'is_consignment' => $isConsignment,
                'consignor_share_type' => $consignorShareType,
                'consignor_share' => $isConsignment ? $consignorShare : null,
                'cost_price' => !$isConsignment ? $costPrice : null,
            ];
        }

        foreach ($items as $item) {
            Product::query()->updateOrCreate(
                [
                    'category_id' => $item['category_id'],
                    'name' => $item['name'],
                ],
                $item,
            );
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }

    private function toInteger(mixed $value): int
    {
        return (int) preg_replace('/[^0-9]/', '', (string) $value);
    }

    private function toBoolean(mixed $value): bool
    {
        $normalized = strtolower(trim((string) $value));

        return in_array($normalized, ['1', 'true', 'yes', 'ya', 'y', 'aktif', 'available'], true);
    }
}