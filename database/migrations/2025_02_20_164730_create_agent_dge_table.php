<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_dge', function (Blueprint $table) {
            $table->id();
            $table->string('nom_utilisateur')->unique();
            $table->string('password');
            $table->string('nom');
            $table->string('prenom');
            $table->timestamp('date_creation');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agent_dge');
    }
};
