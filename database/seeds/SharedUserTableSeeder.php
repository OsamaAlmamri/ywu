<?php

use App\ShareUser;
use Illuminate\Database\Seeder;

class SharedUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShareUser::create([
        'name'=>'علي مصلح',
        'email'=>'Mo@gmail.com',
        'password'=>bcrypt('123123123'),
        'type'=>'شريك'
    ]);
        ShareUser::create([
            'name'=>'محمد العزي',
            'email'=>'saleh@gmail.com',
            'password'=>bcrypt('123123123'),
            'type'=>'عضو كتلة'
        ]);
        ShareUser::create([
            'name'=>' احمد الهمداني',
            'email'=>'mohammed@gmail.com',
            'password'=>bcrypt('123123123'),
            'type'=>'شريك'
        ]);
    }
}
