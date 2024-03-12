<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'username'   => 'admin',
            'password'   => bcrypt('password'),
            'role'       => '2',
            'status'     => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'deleted_at' => date('Y-m-d H:i:s'),
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => null,
            'deleted_at' => null
        ]);

        DB::table('users')->insert([
            'username'   => '001',
            'password'   => bcrypt('123456'),
            'role'       => '3',
            'status'     => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'deleted_at' => date('Y-m-d H:i:s'),
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => null,
            'deleted_at' => null
        ]);
    }
}