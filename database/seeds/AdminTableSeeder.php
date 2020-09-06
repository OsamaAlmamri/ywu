<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'Adnan Almaqwali',
            'email'=>'adnan@gmail.com',
            'image'=>sprintf("%02d",1).'.JPG',
            'password'=>bcrypt('123123123')
        ]);
    }
}
