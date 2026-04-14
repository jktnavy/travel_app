<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('origin_city')->index();
            $table->string('destination_city')->index();
            $table->string('origin_label');
            $table->string('destination_label');
            $table->unsignedInteger('estimated_duration_minutes');
            $table->decimal('base_price', 12, 2);
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['origin_city', 'destination_city', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
