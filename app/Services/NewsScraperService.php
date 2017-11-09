<?php

namespace App\Services;

use App\Contracts\BBCNewsServiceInterface;
use App\Contracts\HackerNewsServiceInterface;
use App\Contracts\NewsScraperServiceInterface;
use App\Contracts\SlashDotCrawlerServiceInterface;

class NewsScraperService implements NewsScraperServiceInterface
{
    protected $bbcNewsService;
    protected $hackerNewsService;
    protected $slashDotCrawlerService;

    public function __construct(
        BBCNewsServiceInterface $BBCNewsService,
        HackerNewsServiceInterface $hackerNewsService,
        SlashDotCrawlerServiceInterface $slashDotCrawlerService
    ) {
        $this->bbcNewsService         = $BBCNewsService;
        $this->hackerNewsService      = $hackerNewsService;
        $this->slashDotCrawlerService = $slashDotCrawlerService;
    }

    public function getAllArticles()
    {
        return [
            'bbc_news'    => $this->getArticlesFromBBCNews(),
            'hacker_news' => $this->getArticlesFromHackerNews(),
            'slashdot'    => $this->getArticlesFromSlashdot(),
        ];
    }

    protected function getArticlesFromBBCNews()
    {
        return $this->bbcNewsService->getArticles();
    }

    protected function getArticlesFromHackerNews()
    {
        return $this->hackerNewsService->getArticles();
    }

    protected function getArticlesFromSlashdot()
    {
        return $this->slashDotCrawlerService->getArticles();
    }
}