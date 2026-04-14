<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('booking_id')->constrained();
            $table->foreignId('settled_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('provider', 50)->default('midtrans_snap')->index();
            $table->string('method', 50)->nullable()->index();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->text('snap_redirect_url')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('status', 30)->default('pending')->index();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('expired_at')->nullable()->index();
            $table->json('payload')->nullable();
            $table->json('webhook_payload')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['booking_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
