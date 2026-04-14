<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_route_id')->constrained('routes');
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->dateTime('departure_at')->index();
            $table->dateTime('arrival_at')->nullable();
            $table->dateTime('boarding_close_at')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedSmallInteger('seat_capacity');
            $table->unsignedSmallInteger('booked_seats')->default(0);
            $table->unsignedSmallInteger('available_seats')->default(0);
            $table->string('status', 30)->default('draft')->index();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['travel_route_id', 'departure_at', 'status']);
            $table->index(['vehicle_id', 'departure_at']);
            $table->index(['driver_id', 'departure_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
