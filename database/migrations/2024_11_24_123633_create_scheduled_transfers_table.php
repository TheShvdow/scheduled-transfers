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
        Schema::create('scheduled_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('sender_id');
            $table->string('recipient_phone');
            $table->double('amount');
            $table->dateTime('scheduled_time');
            $table->string('status')->default('pending');
            $table->string('failure_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_transfers');
    }
};
