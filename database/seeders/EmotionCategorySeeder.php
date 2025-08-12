<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmotionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('emotioncategories')->insert([
            ['emotioncategory_name' => '嬉しい'],
            ['emotioncategory_name' => '悲しい'],
            ['emotioncategory_name' => '怒り'],
            ['emotioncategory_name' => '笑える'],
            ['emotioncategory_name' => 'ほんわか'],
            ['emotioncategory_name' => '切ない'],
        ]);
    }
}
