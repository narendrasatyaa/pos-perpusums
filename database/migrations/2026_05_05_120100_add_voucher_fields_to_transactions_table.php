<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('voucher_id')->nullable()->after('user_id')->constrained('vouchers')->nullOnDelete();
            $table->string('voucher_code')->nullable()->after('voucher_id');
            $table->string('discount_type')->nullable()->after('voucher_code');
            $table->integer('discount_value')->default(0)->after('discount_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('voucher_id');
            $table->dropColumn(['voucher_code', 'discount_type', 'discount_value']);
        });
    }
};
