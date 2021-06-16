<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 5; $i++) {


            $cost=$faker->randomFloat(2,0,1000);

            Product::create([
                'category_id' => random_int(1,5),
                'cost' => $cost,
                'stock' => random_int(1,20),
                'priceTotal' => $cost+10,
                'tax' => random_int(1,10),
                'description' => 'Descripcion'. $i,
                'reference' => 'Referencia'. $i,
                'user_id'=>  random_int(1,User::count())
            ]);
        }
    }
}
