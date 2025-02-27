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
        Schema::create('parrains', function (Blueprint $table) {
            $table->id();
            $table->string('numero_electeur');
            $table->foreign('numero_electeur')->references('numero_electeur')->on('electeurs');
            $table->foreignId('candidat_id')->nullable()->constrained('candidats');
            $table->string('telephone')->unique();
            $table->string('email')->unique();
            $table->string('code_authentification')->nullable();
            $table->string('code_validation', 5)->nullable();
            $table->timestamp('date_inscription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parrains');
    }
};
