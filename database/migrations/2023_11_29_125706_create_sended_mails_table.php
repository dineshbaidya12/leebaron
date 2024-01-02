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
        Schema::create('sended_mails', function (Blueprint $table) {
            $table->id();
            $table->text('subject', 190);
            $table->text('content');
            $table->enum('type', ['all', 'r_user_s', 'r_user_a', 'indivisual', 'other'])->default('other');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sended_mails');
    }
};
