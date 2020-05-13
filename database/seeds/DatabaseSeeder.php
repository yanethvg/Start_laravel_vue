<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
            'name' => 'zoila villatoro',
            'email' => 'zoila@gmail.com',
            'email_verified_at' => now(),
            'password' =>Hash::make("holamundo") , // password
            'remember_token' => Str::random(10),
            ]
            );
        // $this->call(UserSeeder::class);
    }
}
