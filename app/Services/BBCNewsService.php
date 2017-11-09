<?php

namespace App\Services;

use App\Contracts\BBCNewsServiceInterface;
use App\Models\BBCNewsArticle;
use Awjudd\FeedReader\FeedReader;
use Carbon\Carbon;
use Nathanmac\Utilities\Parser\Parser;

class BBCNewsService implements BBCNewsServiceInterface
{
    const FEED_URL = 'http://feeds.bbci.co.uk/news/technology/rss.xml';

    protected $feedReader;
    protected $parser;

    public function __construct()
    {
        $this->feedReader = new FeedReader();
        $this->parser     = new Parser();
    }

    public function getArticles()
    {
        $feed     = $this->feedReader->read(self::FEED_URL);
        $rawData  = $feed->raw_data;
        $xmlData  = $this->parser->xml($rawData);
        $articles = collect($xmlData['channel']['item']);

        $existingArticlesUrls = BBCNewsArticle::select('url')->get()->pluck('url');

        foreach ($articles as $article) {
            if ( ! $existingArticlesUrls->contains($article['link'])) {
                BBCNewsArticle::create([
                    'url'          => $article['link'],
                    'title'        => $article['title'],
                    'summary'      => $article['description'],
                    'published_at' => Carbon::parse($article['pubDate'])->format('Y-m-d H:i:s'),
                ]);
            }
        }

        return BBCNewsArticle::all();
    }
}