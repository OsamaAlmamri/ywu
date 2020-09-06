<?php

use App\Employee;
use App\EmployeeCategory;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'name'=>'محمد علي المصقري',
            'email'=>'Mo@gmail.com',
            'password'=>bcrypt('123123123'),
            'category_id'=>EmployeeCategory::inRandomOrder()->first()->id
        ]);
        Employee::create([
            'name'=>'صالح المرفلي',
            'email'=>'saleh@gmail.com',
            'password'=>bcrypt('123123123'),
            'category_id'=>EmployeeCategory::inRandomOrder()->first()->id
        ]);
        Employee::create([
            'name'=>' محمد المحصلاني',
            'email'=>'mohammed@gmail.com',
            'password'=>bcrypt('123123123'),
            'category_id'=>EmployeeCategory::inRandomOrder()->first()->id
        ]);
    }
}
