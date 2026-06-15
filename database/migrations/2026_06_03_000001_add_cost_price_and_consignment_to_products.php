<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('cost_price')->nullable()->after('price');
            $table->boolean('is_consignment')->default(false)->after('cost_price');
            $table->integer('consignor_share')->nullable()->comment('percent value 0-100')->after('is_consignment');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'is_consignment', 'consignor_share']);
        });
    }
};
