<?php


use App\Models\UserContents\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'=>'استشارة اسرية',
        ]);
        Category::create([
            'name'=>'استشارة نفسية',
        ]);
        Category::create([
            'name'=>'استشارة قانونية',
        ]);
        Category::create([
            'name'=>'شكاوى',
        ]);
    }
}
