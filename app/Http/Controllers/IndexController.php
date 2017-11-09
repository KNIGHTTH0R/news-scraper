<?php

namespace App\Http\Controllers;

use App\Contracts\BBCNewsServiceInterface;
use App\Contracts\HackerNewsServiceInterface;
use App\Contracts\NewsScraperServiceInterface;
use App\Contracts\SlashDotCrawlerServiceInterface;

class IndexController extends Controller
{
    public function index(NewsScraperServiceInterface $newsScraperService)
    {
        $articles = $newsScraperService->getAllArticles();

        return view('pages.all', compact('articles'));
    }

    public function bbcNews(BBCNewsServiceInterface $BBCNewsService)
    {
        return view('pages.individual', [
            'pageTitle' => 'BBC News',
            'articles'  => $BBCNewsService->getArticles(),
            'section'   => 'sections.bbc_news_section',
        ]);
    }

    public function hackerNews(HackerNewsServiceInterface $hackerNewsService)
    {
        return view('pages.individual', [
            'pageTitle' => 'Hacker News',
            'articles'  => $hackerNewsService->getArticles(),
            'section'   => 'sections.hacker_news_section',
        ]);
    }

    public function slashdot(SlashDotCrawlerServiceInterface $slashDotCrawlerService)
    {
        return view('pages.individual', [
            'pageTitle' => 'Slashdot',
            'articles'  => $slashDotCrawlerService->getArticles(),
            'section'   => 'sections.slashdot_section',
        ]);
    }

}
