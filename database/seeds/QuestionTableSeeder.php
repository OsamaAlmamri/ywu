<?php

use App\Exam;
use App\Question;
use Faker\Factory;
use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
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
            Question::create([
                'text'=> $faker->sentence(10),
                'image'=>sprintf("%02d",$i).'.JPG',
                'option1'=> $faker->sentence(2),
                'option2'=> $faker->sentence(2),
                'option3'=> $faker->sentence(2),
                'option4'=> $faker->sentence(2),
                'answer'=> $faker->sentence(2),
                'exam_id'=>Exam::inRandomOrder()->first()->id,
            ]);
        }
    }
}
