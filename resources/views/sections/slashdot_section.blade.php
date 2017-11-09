<section class="news-section slashdot_section">
    <div class="articles slashdot">
        @foreach($articles as $article)
            @include('partials.article', [
                'source'  => 'slashdot',
                'title'   => $article->title,
                'summary'   => $article->summary,
                'date'   => $article->published_at,
                'url'   => $article->url,
            ])
        @endforeach
    </div>
</section>