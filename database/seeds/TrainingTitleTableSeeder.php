<?php


use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TrainingTitleTableSeeder extends Seeder
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
            TrainingTitle::create([
                'name'=> $faker->sentence(2),
                'training_id'=>Training::inRandomOrder()->first()->id,
            ]);
        }
    }
}
