<?php


use App\Models\TrainingContents\TitleContent;
use App\Models\TrainingContents\TrainingTitle;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TitleContentTableSeeder extends Seeder
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
            TitleContent::create([
                'title'=> $faker->sentence(3),
                'body'=> $faker->paragraph(),
                'image'=>sprintf("%02d",$i).'.JPG',
                'book'=>sprintf("book".$i,$i).'.pdf',
                'sound'=>sprintf("sound".$i,$i).'.mp3',
                'video_url'=>sprintf("http//video_url".$i,$i).'.com',
                'title_id'=>TrainingTitle::inRandomOrder()->first()->id,
            ]);
        }
    }
}
