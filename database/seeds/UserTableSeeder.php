<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Adnan Almaqwali',
            'phone'=>774785566,
            'password'=>bcrypt('123123123')
        ]);
        User::create([
            'name'=>'Ali Almaqwali',
            'phone'=>733771547,
            'password'=>bcrypt('123123123')
        ]);
        User::create([
            'name'=>'Ahmed Almaqwali',
            'phone'=>734455687,
            'password'=>bcrypt('123123123')
        ]);
    }
}
