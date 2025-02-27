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
        Schema::table('parrains', function (Blueprint $table) {
            $table->string('telephone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->dateTime('date_inscription')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parrains', function (Blueprint $table) {
            $table->string('telephone')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->dateTime('date_inscription')->nullable(false)->change();
        });
    }
};
