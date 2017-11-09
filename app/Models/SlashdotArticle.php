<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlashdotArticle extends Model
{
    protected $table = 'slashdot_articles';

    protected $fillable = [
        'title',
        'summary',
        'url',
        'published_at',
    ];
}
