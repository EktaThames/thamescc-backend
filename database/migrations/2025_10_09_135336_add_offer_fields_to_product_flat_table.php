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
         Schema::table('product_flat', function (Blueprint $table) {
        $table->string('por_percentage', 50)->nullable()->after('price');
        $table->string('rrp_price', 50)->nullable()->after('por_percentage');
        $table->string('custom_product_subtitle', 255)->nullable()->after('rrp_price');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_flat', function (Blueprint $table) {
        $table->dropColumn(['por_percentage', 'rrp_price', 'custom_product_subtitle']);
    });
    }
};
