<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('trainer_id');
            $table->string('user_type')->default('client');
            $table->string('photo_url')->nullable();
            $table->string('height')->default('180');
            $table->string('weight')->default('80');
            $table->integer('age')->default('25');
            $table->string('description')->default('The pain that you feel today is going to serve as your strength tomorrow.');
            $table->string('city')->default('France, Paris');;
            $table->integer('phone_number')->default('+123456789');
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
        Schema::dropIfExists('clients');
    }
}
