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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->text('heading', 190);
            $table->text('pagecontent');
            $table->text('seo_file_name', 190)->nullable();
            $table->integer('orderby');
            $table->text('title', 190)->nullable();
            $table->text('meta_description', 190)->nullable();
            $table->text('keyword', 190)->nullable();
            $table->enum('disaplay_on', ['top_nav', 'footer', 'top_nav_and_footer', 'other', 'not_visible'])->default('other');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('default_meta', ['yes', 'no'])->default('yes');
            $table->enum('archive', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
