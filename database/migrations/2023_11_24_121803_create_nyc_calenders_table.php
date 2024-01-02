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
        Schema::create('nyc_calenders', function (Blueprint $table) {
            $table->id();
            $table->date('start_time');
            $table->date('end_time');
            $table->text('notes');
            $table->enum('status', ['active', 'inactive']);
            $table->enum('archive', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nyc_calenders');
    }
};
