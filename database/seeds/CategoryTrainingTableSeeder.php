<?php

use App\Category_Training;
use App\EmployeeCategory;
use App\Models\TrainingContents\Training;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CategoryTrainingTableSeeder extends Seeder
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
            Category_Training::create([
                'category_id'=>EmployeeCategory::inRandomOrder()->first()->id,
                'training_id'=>Training::inRandomOrder()->first()->id,
            ]);
        }
    }
}
