<?php


use App\Models\WomenContents\WomenCategory;
use App\Models\WomenContents\WomenPosts;
use Illuminate\Database\Seeder;
use Faker\Factory;
class WomenPostsTableSeeder extends Seeder
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
            WomenPosts::create([
                'title'=> $faker->sentence(),
                'body'=> $faker->paragraph(),
                'image'=>sprintf("%02d",$i).'.JPG',
                'book'=>sprintf("book".$i,$i).'.pdf',
                'sound'=>sprintf("sound".$i,$i).'.mp3',
                'video_url'=>sprintf("http//video_url".$i,$i).'.com',
                'category_id'=>WomenCategory::inRandomOrder()->first()->id,
            ]);
        }
    }
}
