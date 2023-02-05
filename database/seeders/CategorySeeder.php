<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['title' => 'Компьютеры', 'user_id' => 1],
            ['title' => 'Принтеры и сканеры', 'user_id' => 1],
            ['title' => 'Сетевое оборудование', 'user_id' => 1]
        ]);
    }
}
