<?php

use App\Exam;
use App\Models\TrainingContents\Training;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ExamTableSeeder extends Seeder
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
            Exam::create([
                'name'=> $faker->sentence(2),
                'training_id'=>Training::inRandomOrder()->first()->id,
            ]);
        }
    }
}
