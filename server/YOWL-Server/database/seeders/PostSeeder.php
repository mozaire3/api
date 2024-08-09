<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=\Faker\Factory::create();
        for ($i=0; $i<30 ; $i++) {
            Post::create([

                'title'=>$faker->title(),
                'url'=>$faker->url(),
                'content'=>$faker->paragraph(3),
                'user_id'=>$faker->numberBetween(0,100),
                'category_id'=>$faker->numberBetween(0,100),
                'user_id'=>$faker->numberBetween(0,100),
                'category_id'=>$faker->numberBetween(0,100),
            ]);
        }
    }
}
