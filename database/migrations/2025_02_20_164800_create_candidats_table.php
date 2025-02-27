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
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('numero_electeur');
            $table->foreign('numero_electeur')->references('numero_electeur')->on('electeurs');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('parti_politique');
            $table->text('slogan')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('couleur1')->nullable();
            $table->string('couleur2')->nullable();
            $table->string('couleur3')->nullable();
            $table->string('url_page')->nullable();
            $table->string('code_securite');
            $table->string('code_validation', 5);
            $table->timestamp('date_enregistrement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
