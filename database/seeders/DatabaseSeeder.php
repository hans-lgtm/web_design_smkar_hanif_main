<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Dev;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'player1',
            'password' => Hash::make('helloworld1')
        ]);

        User::create([
            'username' => 'player2',
            'password' => Hash::make('helloworld2')
        ]);

        Admin::create([
            'username' => 'admin1',
            'password' => Hash::make('hellouniverse1')
        ]);

        Admin::create([
            'username' => 'admin2',
            'password' => Hash::make('hellouniverse2')
        ]);

         Dev::create([
            'username' => 'dev1',
            'password' => Hash::make('hellobyte1')
        ]);

        Dev::create([
            'username' => 'dev2',
            'password' => Hash::make('hellobyte2'),
        ]);

        Game::create([
            'title' => 'GTA 1',
            'description' => 'GTASKDA',
            'slug' => 'dsaddk-skdjsad',
            'thumbnail' => asset('download.jpeg'),
        ]);

         Game::create([
            'title' => 'GTA 2',
            'description' => 'GTASKDA',
            'slug' => 'dsaddk-skddfsa',
            'thumbnail' => asset('download.jpeg'),
        ]);


    }
}
