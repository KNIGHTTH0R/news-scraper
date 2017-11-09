<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HackerNewsArticle extends Model
{
    protected $table = 'hacker_news_articles';

    protected $fillable = [
        'hacker_news_id',
        'title',
        'summary',
        'url',
        'published_at',
    ];
}
