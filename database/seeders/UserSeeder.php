<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        $faker = \Faker\Factory::create();


        User::create([
            'name' => 'Jesús',
            'email' => 'jcharris.villa@gmail.com',
            'password' => Hash::make('chaviweb1993'),
            'role' => 'admin',
            'active' => 1
        ]);

       /*  $password='chaviweb';

         // And now, let's create a few articles in our database:
         for ($i = 0; $i <5; $i++) {

            User::create([
                'name' => $faker->word,
                'email' => $faker->email,
                'password' => $password,
                'role' => 'user',
                'active' => 1,
            ]);
        } */
    }
}
