<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('employee_code')->nullable()->unique()->after('id');
            $table->string('phone', 30)->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('password');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->text('notes')->nullable()->after('last_login_at');
            $table->index(['is_active', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['is_active', 'created_at']);
            $table->dropColumn([
                'employee_code',
                'phone',
                'is_active',
                'last_login_at',
                'notes',
            ]);
        });
    }
};
