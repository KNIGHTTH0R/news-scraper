<section class="news-section hacker_news_section">
    <div class="articles hacker_news">
        @foreach($articles as $article)
            @include('partials.article', [
                'source'  => 'hacker_news',
                'title'   => $article->title,
                'summary'   => $article->summary,
                'date'   => \Carbon\Carbon::parse($article->published_at)->toDayDateTimeString(),
                'url'   => $article->url,
            ])
        @endforeach
    </div>
</section>