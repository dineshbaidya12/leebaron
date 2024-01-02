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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 190);
            $table->text('address')->nullable();
            $table->text('address2')->nullable();
            $table->text('city')->nullable();
            $table->integer('country');
            $table->string('state', 100);
            $table->string('phone', 15);
            $table->string('email', 190);
            $table->string('postcode', 10);
            $table->date('appointment_date')->nullable();
            $table->timestamp('request_date')->useCurrent();
            $table->enum('status', ['waiting', 'accepted', 'expired', 'cancled'])->default('waiting');
            $table->enum('archive', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
