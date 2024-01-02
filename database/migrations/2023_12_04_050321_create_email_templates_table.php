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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->text('subject', 250);
            $table->text('content');
            $table->enum('type', ['waiting_activation', 'acc_activated', 'acc_suspended', 'forgot_pass', 'enquiry', 'subscription', 'apointment', 'apointment_confirmation', 'apointment_reminder', 'new_order', 'dispatched', 'processing', 'cancelled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
