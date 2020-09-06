<?php


use App\Models\UserContents\Category;
use App\Models\UserContents\Post;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();
        for($i=1;$i<30;$i++){
            Post::create([
                'title'=> $faker->sentence(4),
                'body'=> $faker->paragraph(),
                'user_id'=>User::inRandomOrder()->first()->id,
                'category_id'=>Category::inRandomOrder()->first()->id,
            ]);
        }
    }
}
