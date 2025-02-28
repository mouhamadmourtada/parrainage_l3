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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom_utilisateur')->unique();
            $table->string('password');
            $table->string('userable_type');
            $table->unsignedBigInteger('userable_id');
            $table->timestamp('date_creation');
            $table->rememberToken();
            $table->timestamps();

            $table->index(['userable_type', 'userable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
