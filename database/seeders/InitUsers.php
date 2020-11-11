<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; 
use App\Models\GuestClient; 
use App\Models\Trainer; 
use App\Models\Client; 

class InitUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trainer::create([
            'full_name' => 'Vladan Admin', 
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

        Client::create([
            'full_name' => 'Guest Ilic', 
            'email' => 'milosilic@hotmail.fr', 
            'password' => bcrypt('password'),
            'user_type' => 'guest',
            'trainer_id' => 1
        ]);

        Trainer::create([
            'full_name' => 'Vladan Trainer', 
            'email' => 'stevanka988@gmail.com', 
            'password' => bcrypt('password'),
        ]);

        Client::create([
            'full_name' => 'Marko Nikolic', 
            'email' => 'vlada.pyth@gmail.com', 
            'password' => bcrypt('password'),
            'trainer_id' => 2
        ]);
    }
}
