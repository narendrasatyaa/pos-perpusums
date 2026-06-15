<?php

use App\Models\Product;
use App\Models\StockInbound;
use App\Models\StockAdjustment;
use App\Models\StockMutation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('stock inbound triggers stock increase and stock mutation log', function () {
    $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $product = Product::create([
        'name' => 'Kopi Arabika',
        'price' => 15000,
        'cost_price' => 10000,
        'stock' => 5,
        'min_stock' => 2,
        'unit' => 'pcs',
    ]);

    $inbound = StockInbound::create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'quantity' => 10,
        'cost_price' => 9000,
        'received_at' => now(),
        'supplier' => 'PT. Kopi Nusantara',
    ]);

    // Check stock updated
    $product->refresh();
    expect($product->stock)->toBe(15);
    expect($product->cost_price)->toBe(9000);

    // Check mutation created
    $mutation = StockMutation::where('product_id', $product->id)->first();
    expect($mutation)->not->toBeNull();
    expect($mutation->type)->toBe('inbound');
    expect($mutation->quantity_before)->toBe(5);
    expect($mutation->quantity_change)->toBe(10);
    expect($mutation->quantity_after)->toBe(15);
    expect($mutation->reference_id)->toBe($inbound->id);
    expect($mutation->reference_type)->toBe(StockInbound::class);
});

test('stock adjustment waste triggers stock decrease and stock mutation log', function () {
    $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $product = Product::create([
        'name' => 'Kopi Arabika',
        'price' => 15000,
        'cost_price' => 10000,
        'stock' => 10,
        'min_stock' => 2,
        'unit' => 'pcs',
    ]);

    $adjustment = StockAdjustment::create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'type' => 'waste',
        'quantity' => 3,
        'adjusted_at' => now(),
        'notes' => 'Tumpah',
    ]);

    // Check stock updated
    $product->refresh();
    expect($product->stock)->toBe(7);

    // Check mutation created
    $mutation = StockMutation::where('product_id', $product->id)->first();
    expect($mutation)->not->toBeNull();
    expect($mutation->type)->toBe('adjustment');
    expect($mutation->quantity_before)->toBe(10);
    expect($mutation->quantity_change)->toBe(-3);
    expect($mutation->quantity_after)->toBe(7);
    expect($mutation->reference_id)->toBe($adjustment->id);
    expect($mutation->reference_type)->toBe(StockAdjustment::class);
});

test('stock adjustment correction_add triggers stock increase and stock mutation log', function () {
    $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $product = Product::create([
        'name' => 'Kopi Arabika',
        'price' => 15000,
        'cost_price' => 10000,
        'stock' => 10,
        'min_stock' => 2,
        'unit' => 'pcs',
    ]);

    $adjustment = StockAdjustment::create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'type' => 'correction_add',
        'quantity' => 4,
        'adjusted_at' => now(),
        'notes' => 'Lebih satu dus saat opname',
    ]);

    // Check stock updated
    $product->refresh();
    expect($product->stock)->toBe(14);

    // Check mutation created
    $mutation = StockMutation::where('product_id', $product->id)->first();
    expect($mutation)->not->toBeNull();
    expect($mutation->type)->toBe('adjustment');
    expect($mutation->quantity_before)->toBe(10);
    expect($mutation->quantity_change)->toBe(4);
    expect($mutation->quantity_after)->toBe(14);
});
