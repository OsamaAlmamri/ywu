<?php

use App\Models\WomenContents\WomenCategory;
use Illuminate\Database\Seeder;

class WomenCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WomenCategory::create([
            'name'=>'تنظيم الاسرة',
        ]);
        WomenCategory::create([
            'name'=>'إجتماعية',
        ]);
        WomenCategory::create([
            'name'=>'ثقافية',
        ]);
    }
}
