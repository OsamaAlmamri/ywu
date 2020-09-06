<?php

use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\Training;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TrainingTableSeeder extends Seeder
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
            Training::create([
                'name'=> $faker->sentence(2),
                'type'=>'عام',
                'length'=> sprintf("hours $i"),
                'start_at'=>$faker->dateTime(),
                'end_at'=>$faker->dateTime(),
                'thumbnail'=>sprintf("%02d",$i).'.JPG',
                'subject_id'=>Subject::inRandomOrder()->first()->id,
            ]);
        }
    }
}
