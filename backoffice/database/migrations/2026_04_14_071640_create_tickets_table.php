<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('booking_passenger_id')->nullable()->constrained();
            $table->string('ticket_code')->unique();
            $table->string('status', 30)->default('pending')->index();
            $table->string('qr_token')->nullable()->unique();
            $table->dateTime('issued_at')->nullable();
            $table->dateTime('used_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['booking_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
