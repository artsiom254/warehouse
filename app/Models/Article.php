<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['art_id', 'amount', 'name', 'stock'];

    public function products()
    {
        return $this->hasMany(ProductArticles::class);
    }
}
