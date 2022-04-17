<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductArticles extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'article_id', 'amount'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'article_id');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class, 'product_id');
    }
}
