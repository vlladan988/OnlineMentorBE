<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestClient; 
use App\Models\Trainer; 
use App\Models\Client; 
use App\Models\RecipeType;
use App\Models\Recipe;

class InitUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipeTypes =['Keto', 'Paleo', 'Vegan', 'Detox'];


        Trainer::create([
            'full_name' => 'Vladan Stevanovic', 
            'email' => 'vlladan988@gmail.com', 
            'password' => bcrypt('password'),
            'user_type' => 'admin'
        ]);

        // GuestClient::create([
        //     'full_name' => 'Milos Ilic', 
        //     'email' => 'milosilic@hotmail.fr', 
        //     'password' => bcrypt('password'),
        //     'trainer_id' => 1
        // ]);

        // Client::create([
        //     'full_name' => 'Guest Ilic', 
        //     'email' => 'milosilic@hotmail.fr', 
        //     'password' => bcrypt('password'),
        //     'user_type' => 'guest',
        //     'trainer_id' => 1
        // ]);

        Trainer::create([
            'full_name' => 'Vladan Trainer', 
            'email' => 'stevanka988@gmail.com', 
            'password' => bcrypt('password'),
        ]);

        foreach($recipeTypes as $type){
            RecipeType::create([
                'name' => $type
            ]);
        }

        // Recipe::create([
        //     'trainer_id' => 1,
        //     'name' => 'Piletina',
        //     'recipe_description' => 'Opis',
        // ]);

        // Client::create([
        //     'full_name' => 'Marko Nikolic', 
        //     'email' => 'vlada.pyth@gmail.com', 
        //     'password' => bcrypt('password'),
        //     'trainer_id' => 2
        // ]);
    }
}
