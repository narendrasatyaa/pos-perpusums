<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class BackfillProductSkusSeeder extends Seeder
{
    public function run(): void
    {
        Product::withoutEvents(function () {
            Product::whereNull('sku')->orderBy('id')->chunk(100, function ($products) {
                foreach ($products as $product) {
                    $product->sku = sprintf('PRD-%06d', $product->id);
                    $product->save();
                }
            });
        });
    }
}
