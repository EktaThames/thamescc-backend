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
    Schema::table('customers', function (Blueprint $table) {
        $table->string('business_trading_name')->nullable();
        $table->string('type_of_business')->nullable();
        $table->string('entity')->nullable();

        $table->string('trading_street')->nullable();
        $table->string('trading_address_line_2')->nullable();
        $table->string('trading_city')->nullable();
        $table->string('trading_postal_code')->nullable();
        $table->string('trading_country')->nullable();
        $table->string('trading_phone')->nullable();
        $table->string('trading_email')->nullable();

        $table->string('owner_first_name')->nullable();
        $table->string('owner_last_name')->nullable();
        $table->string('owner_street')->nullable();
        $table->string('owner_address_line_2')->nullable();
        $table->string('owner_city')->nullable();
        $table->string('owner_postal_code')->nullable();
        $table->string('owner_country')->nullable();
        $table->string('owner_phone')->nullable();
        $table->string('owner_email')->nullable();
        $table->string('vat_number')->nullable();
        $table->boolean('not_vat_registered')->default(false);

        $table->string('eoid')->nullable();
        $table->string('fid')->nullable();
        $table->string('company_registration_number')->nullable();

        $table->string('registered_street')->nullable();
        $table->string('registered_apartment')->nullable();
        $table->string('registered_city')->nullable();
        $table->string('registered_postal')->nullable();
        $table->string('registered_country')->nullable();
        $table->string('referred_by')->nullable();

        $table->boolean('id_address_proof')->default(false);
        $table->boolean('accept_terms')->default(false);
        $table->boolean('accept_processing')->default(false);
        $table->boolean('accept_marketing')->default(false);
    });
}

public function down(): void
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropColumn([
            'business_trading_name',
            'type_of_business',
            'entity',
            'trading_street',
            'trading_address_line_2',
            'trading_city',
            'trading_postal_code',
            'trading_country',
            'trading_phone',
            'trading_email',
            'owner_first_name',
            'owner_last_name',
            'owner_street',
            'owner_address_line_2',
            'owner_city',
            'owner_postal_code',
            'owner_country',
            'owner_phone',
            'owner_email',
            'vat_number',
            'not_vat_registered',
            'eoid',
            'fid',
            'company_registration_number',
            'registered_street',
            'registered_apartment',
            'registered_city',
            'registered_postal',
            'registered_country',
            'referred_by',
            'id_address_proof',
            'accept_terms',
            'accept_processing',
            'accept_marketing',
        ]);
    });
}

};
