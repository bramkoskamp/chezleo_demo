<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinnerTableTable extends Migration
{
    public function up()
    {
        Schema::create('dinner_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Naam van de tafel, bijv. "Tafel 1"
            $table->integer('seats');        // Aantal zitplaatsen
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dinner_tables');
    }
}

