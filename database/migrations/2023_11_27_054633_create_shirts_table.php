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
        Schema::create('shirts', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['Fabrics', 'Fit', 'Collars', 'Sleeves', 'Cuffs', 'Front', 'Pocket', 'Bottom Cut', 'Back Details']);
            $table->text('product_name', 190);
            $table->text('image')->nullable();
            $table->integer('orderby');
            $table->enum('status',  ['active', 'inactive']);
            $table->enum('archive',  ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shirts');
    }
};
