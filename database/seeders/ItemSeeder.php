<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BrandSeederの内容
        $brandRolaxId = 1;
        $brandNishibaId = 2;
        $brandStarbacksId = 3;

        // Category IDの再定義（IDの昇順に並び替え、可読性を向上）
        $categoryMenId = 1;         // ID=1: メンズ
        $categoryCosmeId = 4;       // ID=4: レディース (コスメとして利用)
        $categoryAccessoryId = 5;   // ID=5: アクセサリー
        $categoryPCId = 6;          // ID=6: 家電・PC・スマホ
        $categoryFoodId = 7;        // ID=7: 食料品・日用品
        $categoryBagId = 8;         // ID=8: バッグ

        // 1. 商品データ挿入 (合計10件) - created_at は ID が大きいほど新しくなるように調整
        $items = [
            // ID=1: 腕時計 (価格: 15,000)
            [
                'id' => 1, 'user_id' => 1, 'brand_id' => $brandRolaxId, 'name' => '腕時計',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000, 'condition' => '良好', 'image_path' => 'watch.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(1), 'updated_at' => now()->addMinutes(1),
            ],
            // ID=2: HDD (価格: 5,000)
            [
                'id' => 2, 'user_id' => 2, 'brand_id' => $brandNishibaId, 'name' => 'HDD',
                'description' => '高速で頼性の高いハードディスク',
                'price' => 5000, 'condition' => '目立った傷や汚れなし', 'image_path' => 'HDD.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(2), 'updated_at' => now()->addMinutes(2),
            ],
            // ID=3: 玉ねぎ3束 (価格: 300, ブランドなし)
            [
                'id' => 3, 'user_id' => 3, 'brand_id' => null, 'name' => '玉ねぎ3束',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300, 'condition' => 'やや傷や汚れあり', 'image_path' => 'onion.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(3), 'updated_at' => now()->addMinutes(3),
            ],
            // ID=4: 革靴 (価格: 4,000, 販売済み)
            [
                'id' => 4, 'user_id' => 4, 'brand_id' => null, 'name' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000, 'condition' => '状態が悪い', 'image_path' => 'leather_shoes.jpg', 'is_sold' => true,
                'created_at' => now()->addMinutes(4), 'updated_at' => now()->addMinutes(4),
            ],
            // ID=5: ノートPC (価格: 45,000, ブランドなし)
            [
                'id' => 5, 'user_id' => 5, 'brand_id' => null, 'name' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'price' => 45000, 'condition' => '良好', 'image_path' => 'notebook_pc.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(5), 'updated_at' => now()->addMinutes(5),
            ],
            // ID=6: マイク (価格: 8,000, ブランドなし)
            [
                'id' => 6, 'user_id' => 1, 'brand_id' => null, 'name' => 'マイク',
                'description' => '高品質のレコーディング用マイク',
                'price' => 8000,
                'condition' => '目立った傷や汚れなし', 'image_path' => 'microphone.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(6), 'updated_at' => now()->addMinutes(6),
            ],
            // ID=7: ショルダーバッグ (価格: 3,500, ブランドなし)
            [
                'id' => 7, 'user_id' => 2, 'brand_id' => null, 'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'condition' => 'やや傷や汚れあり', 'image_path' => 'shoulder_bag.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(7), 'updated_at' => now()->addMinutes(7),
            ],
            // ID=8: タンブラー (価格: 500, ブランドなし)
            [
                'id' => 8, 'user_id' => 3, 'brand_id' => null, 'name' => 'タンブラー',
                'description' => '使いやすいタンブラー',
                'price' => 500, 'condition' => '状態が悪い', 'image_path' => 'tumbler.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(8), 'updated_at' => now()->addMinutes(8),
            ],
            // ID=9: コーヒーミル (価格: 4,000)
            [
                'id' => 9, 'user_id' => 4, 'brand_id' => $brandStarbacksId, 'name' => 'コーヒーミル',
                'description' => '手動のコーヒーミル',
                'price' => 4000, 'condition' => '良好', 'image_path' => 'coffee_mill.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(9), 'updated_at' => now()->addMinutes(9),
            ],
            // ID=10: メイクセット (価格: 2,500, ブランドなし)
            [
                'id' => 10, 'user_id' => 5, 'brand_id' => null, 'name' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'price' => 2500, 'condition' => '目立った傷や汚れなし', 'image_path' => 'makeup_set.jpg', 'is_sold' => false,
                'created_at' => now()->addMinutes(10), 'updated_at' => now()->addMinutes(10),
            ],
        ];

        DB::table('items')->insert($items);

        // 2. カテゴリ・商品中間テーブルデータ挿入
        $categoryItem = [
            ['item_id' => 1, 'category_id' => $categoryMenId],
            ['item_id' => 1, 'category_id' => $categoryAccessoryId],
            ['item_id' => 2, 'category_id' => $categoryPCId],
            ['item_id' => 3, 'category_id' => $categoryFoodId],
            ['item_id' => 4, 'category_id' => $categoryMenId],
            ['item_id' => 5, 'category_id' => $categoryPCId],
            ['item_id' => 6, 'category_id' => $categoryPCId],
            ['item_id' => 7, 'category_id' => $categoryBagId],
            ['item_id' => 8, 'category_id' => $categoryFoodId],
            ['item_id' => 9, 'category_id' => $categoryFoodId],
            ['item_id' => 10, 'category_id' => $categoryCosmeId],
        ];

        DB::table('category_item')->insert($categoryItem);

        // 3. いいねデータ挿入
        DB::table('likes')->insert([
            ['item_id' => 1, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['item_id' => 1, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['item_id' => 2, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['item_id' => 5, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}