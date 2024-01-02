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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('cateogry');
            $table->text('name', 190);
            $table->text('product_code', 190);
            $table->text('price', 190);
            $table->text('description');
            $table->text('main_img', 190)->nullable();
            $table->enum('default_meta', ['yes', 'no']);
            $table->text('page_title', 190)->nullable();
            $table->text('meta_key', 190)->nullable();
            $table->text('meta_desc', 190)->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->enum('archive', ['yes', 'no'])->default('no');
            $table->interger('orderby');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
