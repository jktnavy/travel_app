<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickup_points', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('travel_route_id')->constrained('routes')->cascadeOnDelete();
            $table->string('name');
            $table->string('city')->index();
            $table->string('direction', 20)->default('departure')->index();
            $table->text('address');
            $table->string('contact_phone', 30)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['travel_route_id', 'direction', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_points');
    }
};
