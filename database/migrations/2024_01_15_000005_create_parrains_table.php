<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parrains', function (Blueprint $table) {
            $table->id('parrain_id');
            $table->foreignId('electeur_id')->constrained('electeurs');
            $table->foreignId('candidat_id')->nullable()->constrained('candidats', 'candidat_id');
            $table->string('telephone')->unique();
            $table->string('email')->unique();
            $table->string('code_authentification')->nullable();
            $table->string('code_validation')->nullable();
            $table->timestamp('date_inscription');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parrains');
    }
};
