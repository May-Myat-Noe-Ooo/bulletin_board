<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class PostlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('postlists')->insert([
            [
                    'title'=>"Front-end",
                    'description'=>'employment',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Back-end",
                    'description'=>'employment',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Back-end",
                    'description'=>'employment',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Back-end",
                    'description'=>'employment',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Back-end",
                    'description'=>'employment',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],


           ] );
    }
}
