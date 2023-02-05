<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ['title' => 'Ноутбук Dell', 'price' => 50000,'category_id' => 1,'user_id' => 1],
            ['title' => 'Ноутбук Samsung', 'price' => 60000, 'category_id' => 1, 'user_id' => 1],
            ['title' => 'Ноутбук Acer', 'price' => 80000, 'category_id' => 1, 'user_id' => 1],
            ['title' => 'МФУ Canon XP-202', 'price' => 30000, 'category_id' => 2, 'user_id' => 1],
            ['title' => 'Сканер HP', 'price' => 10000, 'category_id' => 2, 'user_id' => 1],
            ['title' => 'Роутер MikroTik', 'price' => 7000, 'category_id' => 3, 'user_id' => 1]
        ]);
    }
}
