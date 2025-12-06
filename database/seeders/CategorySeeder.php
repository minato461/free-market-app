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
        $categories = [
            ['id' => 1, 'name' => 'メンズ'],
            ['id' => 2, 'name' => 'トップス'],
            ['id' => 3, 'name' => 'Tシャツ/カットソー'],
            ['id' => 4, 'name' => 'レディース'],
            ['id' => 5, 'name' => 'アクセサリー'],
            ['id' => 6, 'name' => '家電・PC・スマホ'],
            ['id' => 7, 'name' => '食料品・日用品'],
            ['id' => 8, 'name' => 'バッグ'],
        ];

        DB::table('categories')->insert($categories);
    }
}