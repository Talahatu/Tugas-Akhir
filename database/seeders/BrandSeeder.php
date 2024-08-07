<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BrandCategory;
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
        // Brand::factory()->count(100)->create();
        $brands = ["Fantech", "Sony", "Samsung", "Aqua", "Le Minerale", "LPG", "Omicko", "Panasonic", "Toshiba", "Mitsubishi", "Yamaha", "Sarong", "Kusuma", "Bali Batik", "IKEA", "Lio Collection", "Yonex", "Hitachi", "DEKO", "Makita", "Bosch", "Adidas", "Nike", "AlphaTauri", "Versace", "Hermes", "Tom Ford", "Lainnya"];

        foreach ($brands as  $value) {
            DB::table("brands")->insert(["name" => $value]);
        }
        BrandCategory::factory()->count(100)->create();

        for ($i = 1; $i < 24; $i++) {
            DB::table("brand_categories")->insert(["brand_id" => 28, "category_id" => $i]);
        }
    }
}
