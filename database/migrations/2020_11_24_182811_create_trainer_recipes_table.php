<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainerRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_recipes', function (Blueprint $table) {
            $table->id();
            $table->integer('trainer_id');
            $table->string('name');
            $table->string('photo_url')->nullable();
            $table->string('proteins')->nullable()->default('0');
            $table->string('carbohydrates')->nullable()->default('0');
            $table->string('fats')->nullable()->default('0');
            $table->string('calories')->nullable()->default('0');
            $table->string('recipe_type')->nullable();
            $table->longText('recipe_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_recipes');
    }
}
