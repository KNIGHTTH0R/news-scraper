<?php

namespace App\Services;

use App\Contracts\HackerNewsServiceInterface;
use App\Models\HackerNewsArticle;
use Carbon\Carbon;
use GuzzleHttp\Client;

class HackerNewsService implements HackerNewsServiceInterface
{
    const RECENT_STORIES_URL    = 'https://hacker-news.firebaseio.com/v0/newstories.json';
    const STORY_URL             = 'https://hacker-news.firebaseio.com/v0/item/STORY_ID.json';
    const NUM_OF_RECENT_STORIES = 10;

    public function getArticles()
    {
        $recentStoryIds   = $this->getRecentStoryIds();
        $existingStoryIds = HackerNewsArticle::select('hacker_news_id')->get()->pluck('hacker_news_id');

        $newStoryIds = $recentStoryIds->diff($existingStoryIds);
        $this->getNewStories($newStoryIds);

        return HackerNewsArticle::all();
    }

    protected function getRecentStoryIds()
    {
        $client   = new Client();
        $response = $client->request('GET', self::RECENT_STORIES_URL);

        if ($response->getStatusCode() !== 200) {
            logger('Failed to retrieve articles from Hacker News');

            return [];
        }

        return collect(json_decode($response->getBody()))->take(self::NUM_OF_RECENT_STORIES);
    }

    protected function getNewStories($stories)
    {
        foreach ($stories as $storyId) {
            $story = $this->getStoryData($storyId);

            try {
                HackerNewsArticle::create([
                    'hacker_news_id' => $story->id,
                    'title'          => $story->title,
                    'summary'        => $story->title,
                    'url'            => $story->url,
                    'published_at'   => Carbon::createFromTimestamp($story->time)->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                logger('Failed to save story with id: ' . $storyId);
            }
        }
    }

    protected function getStoryData($storyId)
    {
        $client   = new Client();
        $url      = str_replace('STORY_ID', $storyId, self::STORY_URL);
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            logger('Failed to retrieve story data for story id: ' . $storyId);

            return [];
        }

        return json_decode($response->getBody());
    }
}