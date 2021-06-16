<?php

use Illuminate\Database\Seeder;
use App\Models\CategoryProduct;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CategoryProduct::truncate();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i <5; $i++){

            CategoryProduct::create([
                'name' => $faker->word,
            ]);
        }

    }
}
