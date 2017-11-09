<section class="news-section bbc_news_section">
    <div class="articles bbc_news">
        @foreach($articles as $article)
            @include('partials.article', [
                'source'  => 'bbc_news',
                'title'   => $article->title,
                'summary'   => $article->summary,
                'date'   => \Carbon\Carbon::parse($article->published_at)->toDayDateTimeString(),
                'url'   => $article->url,
            ])
        @endforeach
    </div>
</section>