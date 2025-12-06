<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['id' => 1, 'name' => 'Rolax'],
            ['id' => 2, 'name' => '西芝'],
            ['id' => 3, 'name' => 'Starbacks'],
        ];

        DB::table('brands')->insert($brands);
    }
}
