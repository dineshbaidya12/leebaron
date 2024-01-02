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
        Schema::create('users_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('address1', 190);
            $table->text('address2', 190)->nullable();
            $table->text('city', 190);
            $table->unsignedBigInteger('country');
            $table->text('state', 190);
            $table->foreign('country')->references('id')->on('countries');
            $table->text('postcode', 20);
            $table->text('phone', 20);
            $table->text('fax', 20)->nullable();
            $table->enum('status', ['active', 'inactive', 'waiting'])->default('waiting');
            $table->enum('showroom', ['USNY', 'DKCO', 'SWST', 'HKCH', 'CATO'])->default('USNY')->nullable();
            $table->text('customer_no', 50)->nullable();
            $table->date('joined_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_info');
    }
};
