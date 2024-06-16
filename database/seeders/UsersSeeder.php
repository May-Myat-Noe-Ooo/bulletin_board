<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('users')->insert([

        [
            'name' => 'Kenya',
            'email' => 'kenya@gmail.com',
            'password' => Hash::make('password126'),
            'profile' => 'D:\MMNO\bulletin_board\img\karina.jpg',
            'type' => '0',
            'phone' => '912784615',
            'address' => 'magway',
            'dob' => '12.3.2001',
            'create_user_id' => 1,
            'updated_user_id' => 1,
            'deleted_user_id' => 1,
            'creatd_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Ning Ning',
            'email' => 'ningning@gmail.com',
            'password' => Hash::make('password123'),
            'profile' => 'D:\MMNO\bulletin_board\img\karina.jpg',
            'type' => '0',
            'phone' => '912787854',
            'address' => 'Mandalay',
            'dob' => '10.3.2001',
            'create_user_id' => 2,
            'updated_user_id' => 2,
            'deleted_user_id' => 2,
            'creatd_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]
            
        ]);
    }
}
