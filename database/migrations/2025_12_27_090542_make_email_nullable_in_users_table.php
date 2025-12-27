<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make email nullable since we're using phone for login
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NULL');
        } elseif (config('database.default') === 'sqlite') {
            // SQLite doesn't support ALTER COLUMN, so we'll skip this
            // Email can remain as is since we're using phone for login
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL');
        } elseif (config('database.default') !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email')->nullable(false)->change();
            });
        }
    }
};
