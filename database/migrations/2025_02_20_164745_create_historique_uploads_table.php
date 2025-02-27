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
        Schema::create('historique_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_dge_id')->constrained('agent_dge')->onDelete('cascade');
            $table->timestamp('date_upload');
            $table->string('adresse_ip');
            $table->string('checksum_sha256');
            $table->string('lien_fichier_csv');
            $table->boolean('est_succes')->default(false);
            $table->text('message_erreur')->nullable();
            $table->timestamps();

            // Index pour améliorer les performances des recherches
            $table->index(['date_upload', 'est_succes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_uploads');
    }
};
