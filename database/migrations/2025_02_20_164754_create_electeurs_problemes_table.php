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
        Schema::create('electeurs_problemes', function (Blueprint $table) {
            $table->id('probleme_id');
            $table->foreignId('upload_id')->constrained('historique_uploads')->onDelete('cascade');
            $table->string('cin');
            $table->string('numero_electeur');
            $table->text('nature_probleme');
            $table->timestamps();

            // Index pour améliorer les performances des recherches
            $table->index(['upload_id', 'cin', 'numero_electeur']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electeurs_problemes');
    }
};
