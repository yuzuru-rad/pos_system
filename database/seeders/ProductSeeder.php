<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'product_name' => 'おーいお茶　濃い茶',
                'product_code' => 4901085609552,
                'price' => 180,
                'taxrate' => 0.08,
                'taxinclude_price' => 194,
            ],
            [
                'product_name' => 'カシミヤポケットティッシュ4p',
                'product_code' => 4901750474706,
                'price' => 162,
                'taxrate' => 0.1,
                'taxinclude_price' => 178,
            ],
            [
                'product_name' => '三ツ矢サイダーキャンディ',
                'product_code' => 4946842529209,
                'price' => 157,
                'taxrate' => 0.08,
                'taxinclude_price' => 169,
            ],
            // 追加のデータを必要に応じて記述する
        ]);
    }
}
