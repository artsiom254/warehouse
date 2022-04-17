<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    /**
     * Get Articles with article id as array key
     * @return array
     */
    public static function articles(): array
    {
        $articles = Article::all()->toArray();
        $articlesResult = [];
        foreach ($articles as $article) {
            $articlesResult[$article['art_id']] = $article;
        }
        return $articlesResult;
    }

    /**
     * Get articles by provided ids
     * @param $ids
     * @return array
     */
    public static function articlesByIds($ids): array
    {
        return Article::find($ids)->toArray();;
    }

    /**
     * Get articles for single product
     * @param $product
     * @return array
     */
    public static function articlesByProduct($product): array
    {
        $productArticles = $product->articles()->get()->toArray();
        $productArticlesIds = array_map(function ($item) {
            return $item['article_id'];
        }, $productArticles);

        $productArticlesAmount = [];
        foreach ($productArticles as $productArticle) {
            $productArticlesAmount[$productArticle['article_id']] = $productArticle['amount'];
        }
        $articles = ArticleRepository::articlesByIds($productArticlesIds);

        $articlesResult = [];
        foreach ($articles as $article) {
            $article['amount'] = $productArticlesAmount[$article['id']];
            $articlesResult[] = $article;
        }
        return $articlesResult;
    }
}
