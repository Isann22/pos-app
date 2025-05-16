<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            [
                'name' => 'Mawar',
            ],
            [
                'name' => 'Melati',

            ],
            [
                'name' => 'Kering',
            ]
        ];


        foreach ($categories as $c) {
            Category::create($c);
        }
    }
}
