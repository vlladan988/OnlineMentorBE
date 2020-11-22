<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_type')->nullable()->default('trainer');
            $table->string('photo_url')->nullable();
            $table->string('facebook')->nullable()->default('https://facebook.com');
            $table->string('instagram')->nullable()->default('https://instagram.com');
            $table->string('height')->nullable()->default('180');
            $table->string('weight')->nullable()->default('80');
            $table->integer('age')->nullable()->default('25');
            $table->string('description')->nullable()->default('The pain that you feel today is going to serve as your strength tomorrow.');
            $table->string('main_sport')->nullable()->default('Bodybuilding');
            $table->string('city')->nullable()->default('France, Paris');
            $table->string('phone_number')->nullable()->default('+123456789');

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
        Schema::dropIfExists('trainers');
    }
}
