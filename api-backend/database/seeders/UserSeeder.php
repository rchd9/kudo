<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            ['id' => 1, 'name' => 'Bruce W', 'email' => 'brucew@gmail.com', 'password' => bcrypt('123456')],
            ['id' => 2, 'name' => 'John Doe', 'email' => 'johndoe@gmail.com', 'password' => bcrypt('123456')],
            ['id' => 3, 'name' => 'Carlos', 'email' => 'carlos@gmail.com', 'password' => bcrypt('123456')],
        ];

        DB::table('users')->insert($users);
    }
}
