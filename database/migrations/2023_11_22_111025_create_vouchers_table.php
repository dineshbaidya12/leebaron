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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->text('voucher_name', 190);
            $table->text('voucher_code', 190);
            $table->integer('voucher_amount');
            $table->integer('min_applicable');
            $table->enum('discount_type', ['percentage', 'price']);
            $table->enum('status', ['active', 'inactive']);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
