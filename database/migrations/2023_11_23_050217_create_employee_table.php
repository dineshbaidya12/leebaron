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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->text('username', 190);
            $table->text('email', 190);
            $table->text('password', 190);
            $table->enum('showroom', ['USNY', 'DKCO', 'SWST', 'HKCH', 'CATO']);
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
        Schema::dropIfExists('employees');
    }
};
