<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('periodes_parrainage', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->boolean('est_active')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index(['date_debut', 'date_fin', 'est_active']);
        });

        // Add check constraint using raw SQL
        DB::statement('ALTER TABLE periodes_parrainage ADD CONSTRAINT check_dates CHECK (date_debut < date_fin)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes_parrainage');
    }
};
