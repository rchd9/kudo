<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KudosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kudos')->delete();

        $users = [
            ['id' => 1, 'user_id' => '1', 'title' => 'Bruce Birthday', 'created_at' => '2021-12-24'],
            ['id' => 2, 'user_id' => '2', 'title' => 'John Birthday', 'created_at' => '2021-12-24'],
        ];

        DB::table('kudos')->insert($users);
    }
}
