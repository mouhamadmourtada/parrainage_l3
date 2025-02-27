<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('parrains', function (Blueprint $table) {
            $table->foreignId('candidat_id')->nullable()->change();
            $table->string('code_authentification')->nullable()->change();
            $table->string('code_validation')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('parrains', function (Blueprint $table) {
            $table->foreignId('candidat_id')->nullable(false)->change();
            $table->string('code_authentification')->nullable(false)->change();
            $table->string('code_validation')->nullable(false)->change();
        });
    }
};
