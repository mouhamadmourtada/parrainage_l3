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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'userable_type')) {
                $table->string('userable_type')->nullable();
            }
            if (!Schema::hasColumn('users', 'userable_id')) {
                $table->unsignedBigInteger('userable_id')->nullable();
            }
            if (!Schema::hasIndex('users', ['userable_type', 'userable_id'])) {
                $table->index(['userable_type', 'userable_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['userable_type', 'userable_id']);
            $table->dropColumn(['userable_type', 'userable_id']);
        });
    }
};
