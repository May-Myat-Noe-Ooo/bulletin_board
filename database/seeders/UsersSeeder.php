<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'name' => 'Rosy',
            'email' => 'rosy@gmail.com',
            'password' => '111111',
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
        ]);
    }
}
