<?php

use App\Employee;
use App\Models\UserContents\Comment;
use App\Models\UserContents\Post;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();
        for($i=1;$i<15;$i++){
            Comment::create([
                'body'=> $faker->sentence(),
                'user_id'=>User::inRandomOrder()->first()->id,
                'emp_id'=>Employee::inRandomOrder()->first()->id,
                'post_id'=>Post::inRandomOrder()->first()->id,
            ]);
        }
    }
}
