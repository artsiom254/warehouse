<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductArticles;
use File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        ProductArticles::truncate();

        $json = File::get(public_path("import/products.json"));
        $products = json_decode($json);

        foreach ($products->products as $productKey => $product) {
            $created = Product::create([
                "name" => $product->name,
            ]);

            foreach ($product->contain_articles as $key => $value) {
                ProductArticles::create([
                    "product_id" => $created->id,
                    "article_id" => $value->art_id,
                    "amount" => $value->amount_of
                ]);
            }
        }
    }
}
