@extends('app')

@section('title')
    <title>News Scraper | {{ $pageTitle }}</title>
@endsection

@section('content')
<div class="individual">
    <ul class="navbar fixed-top navbar-light bg-primary">
        <h2 class="text-center">{{ $pageTitle }}</h2>
        <a class="show_all" href="/">All</a>

        <li class="nav-item links">
            <a href="/hacker-news" class="{{ $pageTitle == 'Hacker News' ? 'hide' : '' }}">Hacker News</a>
            <a href="/bbc-news" class="{{ $pageTitle == 'BBC News' ? 'hide' : '' }}">BBC News</a>
            <a href="/slashdot" class="{{ $pageTitle == 'Slashdot' ? 'hide' : '' }}">Slashdot</a>
        </li>
    </ul>
    <div class="articles-container">
        <div class="card-columns articles">
            @include($section, ['articles' => $articles])
        </div>
    </div>
</div>
@endsection
