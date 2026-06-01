<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password'); // admin, manager, user
            $table->string('avatar')->nullable()->after('role');
            $table->string('phone')->nullable()->after('avatar');
            $table->string('position')->nullable()->after('phone'); // cargo
            $table->boolean('is_active')->default(true)->after('position');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'phone', 'position', 'is_active', 'last_login_at']);
        });
    }
};