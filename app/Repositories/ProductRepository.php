<?php

namespace App\Repositories;

use App\Models\Product;

/**
 *
 */
class ProductRepository
{
    /**
     * Get products data including quantity and max quantity
     * @return array
     */
    public static function productsWithQuantity(): array
    {
        $products = self::productsWithArticles();
        $productsResult = array_map(function ($p) {
            return [
                'id' => $p['id'],
                'name' => $p['name'],
                'price' => $p['price'],
                'quantity' => 0,
            ];
        }, $products->toArray());
        foreach ($products as $productKey => $product) {
            $productsResult[$productKey]['max_quantity'] = self::productMaxQuantity($product);
        }
        $articlesAvailable = ArticleRepository::articles();
        $products = $products->toArray();
        while (count($products) > 0) {

            foreach ($products as $productKey => $product) {
                if (self::articlesInStock($product['articles'], $articlesAvailable)) {
                    foreach ($product['articles'] as $productArticle) {
                        $articlesAvailable[$productArticle['article_id']]['stock'] -= $productArticle['amount'];
                    }
                    $productsResult[$productKey]['quantity']++;
                } else {
                    unset($products[$productKey]);
                }
            }
        }

        return $productsResult;
    }

    /**
     * Get max quantity for single product
     * @param $product
     * @return mixed
     */
    public static function productMaxQuantity($product)
    {
        $articles = ArticleRepository::articlesByProduct($product);
        $productArticlesQuantities = [];
        foreach ($articles as $article) {
            $productArticlesQuantities[] = intdiv($article['stock'], $article['amount']);
        }
        if (count($productArticlesQuantities)) {
            return min($productArticlesQuantities);
        }
        return 0;
    }

    /**
     * Check if given articles are in stock
     * @param $productArticles
     * @param $articles
     * @return bool
     */
    public static function articlesInStock($productArticles, $articles): bool
    {
        if ($productArticles && count($productArticles) > 0) {
            foreach ($productArticles as $productArticle) {
                if ($productArticle['amount'] > $articles[$productArticle['article_id']]['stock']) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Get Products data including articles for each product
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function productsWithArticles()
    {
        return Product::with('articles')->get();
    }
}
