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
        Schema::create('homepage_sliders', function (Blueprint $table) {
            $table->id();
            $table->text('title', 190);
            $table->text('image')->nullable();
            $table->enum('link_type', ['internal', 'external', 'none'])->default('none');
            $table->text('link')->nullable();
            $table->text('internal_link')->nullable();
            $table->enum('new_window', ['yes', 'no'])->default('no');
            $table->enum('class_name', ['white', 'black'])->default('white');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('order');
            $table->enum('archive', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_sliders');
    }
};
