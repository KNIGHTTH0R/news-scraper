@extends('app')

@section('title')
    <title>News Scraper | All</title>
@endsection

@section('content')
    <ul class="nav nav-tabs justify-content-center" id="navigation" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="hacker-news-tab" data-toggle="tab" href="#hacker-news" role="tab" aria-controls="hacker-news" aria-selected="true">Hacker News</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="bbc-news-tab" data-toggle="tab" href="#bbc-news" role="tab" aria-controls="bbc-news" aria-selected="false">BBC News</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="slashdot-tab" data-toggle="tab" href="#slashdot" role="tab" aria-controls="slashdot" aria-selected="false">Slashdot</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active card-columns" id="hacker-news" role="tabpanel" aria-labelledby="hacker-news-tab">
            @include('sections.hacker_news_section', ['articles' => $articles['hacker_news']])
        </div>
        <div class="tab-pane fade card-columns" id="bbc-news" role="tabpanel" aria-labelledby="bbc-news-tab">
            @include('sections.bbc_news_section', ['articles' => $articles['bbc_news']])
        </div>
        <div class="tab-pane fade card-columns" id="slashdot" role="tabpanel" aria-labelledby="slashdot-tab">
            @include('sections.slashdot_section', ['articles' => $articles['slashdot']])
        </div>
    </div>
@endsection
