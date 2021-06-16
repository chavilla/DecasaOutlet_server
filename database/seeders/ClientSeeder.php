<?php

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        Client::truncate();
        $faker = \Faker\Factory::create();

        // And now, let's create a few clients in our database:
        for ($i = 0; $i < 25; $i++) {
            Client::create([
                'ruc' => $faker->regexify('[1-9]{7}'),
                'name' => $faker->word,
                'lastName' => $faker->word,
                'phone' => $faker->regexify('^6[0-9]{7}'),
                'email' => $faker->email,
                'active' => 1,
            ]);
        }

    }
}
