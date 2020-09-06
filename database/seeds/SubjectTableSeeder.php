<?php

use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\SubjectCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();
        for($i=1;$i<45;$i++){
            Subject::create([
                'name'=> $faker->sentence(2),
                'category_id'=>SubjectCategory::inRandomOrder()->first()->id,
            ]);
        }
    }
}
