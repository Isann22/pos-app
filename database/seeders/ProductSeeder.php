<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $products = [
            [
                'name' => 'Buket Kelulusan',
                'description' => 'Buket bunga segar untuk wisuda',
                'stock' => 15,
                'image' => 'img1.jpeg',
                'price' => 1000,
                'category_id' => 1
            ],
            [
                'name' => 'Buket Ulang Tahun',
                'description' => 'Buket colorful untuk hari spesial',
                'stock' => 10,
                'image' => 'img2.jpeg',
                'price' => 1000,
                'category_id' => 2
            ],
            [
                'name' => 'Bunga Meja Minimalis',
                'description' => 'Rangkaian bunga kecil untuk meja',
                'stock' => 20,
                'image' => 'img3.jpeg',
                'price' => 1000,
                'category_id' => 3
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
