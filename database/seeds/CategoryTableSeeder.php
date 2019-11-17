<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create(['name_en' => 'sports', 'name_ar' => 'رياضة']);
        \App\Category::create(['name_en' => 'clothes', 'name_ar' => 'ملابس']);
        \App\Category::create(['name_en' => 'Mobiles', 'name_ar' => 'جوالات']);
    }
}
