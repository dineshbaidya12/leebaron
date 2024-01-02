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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->text('category_name', 100);
            $table->integer('shipping_price');
            $table->enum('shirt_shop', ['yes', 'no']);
            $table->text('category_desc');
            $table->enum('status', ['active', 'inactive']);
            $table->integer('orderby');
            $table->enum('display_footer', ['yes', 'no']);
            $table->enum('default_meta', ['yes', 'no']);
            $table->text('page_title', 190)->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_keywords', 190)->nullable();
            $table->enum('archive', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
