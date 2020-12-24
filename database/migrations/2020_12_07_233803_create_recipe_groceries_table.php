<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeGroceriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_groceries', function (Blueprint $table) {
            $table->id();
            $table->integer('recipe_id');
            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('unit_type')->nullable();
            $table->integer('proteins')->nullable()->default('0');
            $table->integer('carbons')->nullable()->default('0');
            $table->integer('fats')->nullable()->default('0');
            $table->integer('calories')->nullable()->default('0');
            $table->integer('default_proteins')->nullable()->default('0');
            $table->integer('default_carbons')->nullable()->default('0');
            $table->integer('default_fats')->nullable()->default('0');
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
        Schema::dropIfExists('recipe_groceries');
    }
}
