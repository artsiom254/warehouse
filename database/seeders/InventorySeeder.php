<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use File;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();

        $json = File::get(public_path("import/inventory.json"));
        $articles = json_decode($json);

        foreach ($articles->inventory as $key => $value) {
            Article::create([
                "art_id" => $value->art_id,
                "name" => $value->name,
                "stock" => $value->stock
            ]);
        }
    }
}
