<?php

use App\EmployeeCategory;
use Illuminate\Database\Seeder;

class EmployeeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeCategory::create([
            'name'=>'استشاري',
        ]);
        EmployeeCategory::create([
            'name'=>'مدرب',
        ]);
        EmployeeCategory::create([
            'name'=>'اخصائي',
        ]);
    }
}
