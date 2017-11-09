<?php

namespace App\Services;

use App\Contracts\SlashDotCrawlerServiceInterface;
use App\Models\SlashdotArticle;
use Weidner\Goutte\GoutteFacade as Goutte;

class SlashDotCrawlerService implements SlashDotCrawlerServiceInterface
{
    const CRAWL_URL             = 'http://slashdot.org';
    const ARTICLES_XPATH        = '#firehoselist article';
    const ARTICLE_TITLE_XPATH   = '.story-title > a';
    const ARTICLE_SUMMARY_XPATH = '.story-title > a';
    const ARTICLE_URL_XPATH     = '.story-title > a';
    const ARTICLE_DATE_XPATH    = '.story-byline time';

    public function getArticles()
    {
        $crawler        = Goutte::request('GET', self::CRAWL_URL);
        $recentArticles = [];

        $crawler->filter(self::ARTICLES_XPATH)->each(function ($node) use (&$recentArticles) {
            $title = $node->filter(self::ARTICLE_TITLE_XPATH)->each(function ($title) {
                return $title->text();
            });

            $summary = $node->filter(self::ARTICLE_SUMMARY_XPATH)->each(function ($summary) {
                return $summary->text();
            });

            $url = $node->filter(self::ARTICLE_URL_XPATH)->each(function ($url) {
                return $url->attr('href');
            });

            $publishedAt = $node->filter(self::ARTICLE_DATE_XPATH)->each(function ($date) {
                return $date->text();
            });

            $recentArticles[] = [
                'title'        => $title[0],
                'summary'      => $summary[0],
                'url'          => $url[0],
                'published_at' => $publishedAt[0],
            ];
        });

        $existingArticlesUrls = SlashdotArticle::select('url')->get()->pluck('url');

        foreach ($recentArticles as $article) {
            if ( ! $existingArticlesUrls->contains($article['url'])) {
                SlashdotArticle::create($article);
            }
        }

        return SlashdotArticle::all();
    }
}

