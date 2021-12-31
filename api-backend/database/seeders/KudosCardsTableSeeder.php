<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KudosCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kudo_cards')->delete();

        $users = [
            ['id' => 1, 'kudo_id' => '1', 'subject' => 'good job', 'comment' => 'really good job', 'created_at' => '2021-12-24'],
            ['id' => 2, 'kudo_id' => '1', 'subject' => 'well done', 'comment' => 'Well done', 'created_at' => '2021-12-24'],
        ];

        DB::table('kudo_cards')->insert($users);
    }
}
