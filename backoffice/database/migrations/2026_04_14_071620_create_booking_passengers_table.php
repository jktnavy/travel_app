<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_passengers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('identity_number', 50)->nullable()->index();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('seat_number', 20)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->index(['booking_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_passengers');
    }
};
