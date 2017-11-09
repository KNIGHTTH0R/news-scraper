<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BBCNewsArticle extends Model
{
    protected $table = 'bbc_news_articles';

    protected $fillable = [
        'url',
        'title',
        'summary',
        'published_at',
    ];
}
