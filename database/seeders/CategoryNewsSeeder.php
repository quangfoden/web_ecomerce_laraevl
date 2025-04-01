<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryNews;
class CategoryNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CategoryNews::insert([
            ['name' => 'Tin nổi bật', 'description' => 'Tin tức về Tin nổi bật'],
            ['name' => 'Tin khuyến mãi', 'description' => 'Tin tức Tin khuyến mãi'],
            ['name' => 'Mẹo thời trang', 'description' => 'Tin tức về mẹo thời trang'],
        ]);
    }
}
