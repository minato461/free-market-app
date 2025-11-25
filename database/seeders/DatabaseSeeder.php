<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $items = [
            ['name' => 'メイクアップセット', 'price' => 5800, 'description' => 'プロ仕様のメイクアップセットです。', 'condition' => '新品', 'user_id' => $user->id, 'image_path' => 'makeup_set.jpg'],
            ['name' => '腕時計', 'price' => 12500, 'description' => '高級感のある腕時計です。', 'condition' => '美品', 'user_id' => $user->id, 'image_path' => 'watch.jpg'],
            ['name' => 'コーヒーミル', 'price' => 3200, 'description' => '手動式のコーヒーミルです。', 'condition' => '中古', 'user_id' => $user->id, 'image_path' => 'coffee_mill.jpg'],
            ['name' => 'ショルダーバッグ', 'price' => 7000, 'description' => '使いやすいサイズのバッグです。', 'condition' => '新品', 'user_id' => $user->id, 'image_path' => 'shoulder_bag.jpg'],
            ['name' => 'ノートPC', 'price' => 85000, 'description' => '高性能なノートパソコンです。', 'condition' => '中古', 'user_id' => $user->id, 'image_path' => 'notebook_pc.jpg'],
            ['name' => '革靴', 'price' => 15000, 'description' => 'ビジネスにもカジュアルにも使える革靴です。', 'condition' => '美品', 'user_id' => $user->id, 'image_path' => 'leather_shoes.jpg'],
            ['name' => '玉ねぎ', 'price' => 300, 'description' => '新鮮な玉ねぎです。', 'condition' => '新品', 'user_id' => $user->id, 'image_path' => 'onion.jpg'],
            ['name' => 'タンブラー', 'price' => 1800, 'description' => '保温性の高いタンブラーです。', 'condition' => '新品', 'user_id' => $user->id, 'image_path' => 'tumbler.jpg'],
            ['name' => 'マイク', 'price' => 4500, 'description' => '高品質なコンデンサーマイクです。', 'condition' => '美品', 'user_id' => $user->id, 'image_path' => 'microphone.jpg'],
            ['name' => 'HDD', 'price' => 6000, 'description' => '外付けHDDです。', 'condition' => '中古', 'user_id' => $user->id, 'image_path' => 'HDD.jpg'],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}