# News Scraper

*Coding time: ~3 hours* 

## Frameworks
* I decided to use Laravel 5.5 as the Backend Framework as it allows me to quickly set up a new project with the basic scaffolding
* I used Bootstrap 4 with jQuery for the Frontend so I could quickly apply styles and components  

## Code Summary
### Vagrant
I used Homestead by Laravel to create a Vagrant box 

### Dependencies
* I used `composer` to manage dependencies for the the backend
* I used `npm` to manage dependencies for the frontend

### Routes
News articles can be viewed in two different ways:
 * `/` - the 'home' or 'index' route shows news articles from all three (Hacker News, BBC News and Slashdot) sources, separated using tabbed views
   * This route uses `IndexController@index`
 * `/bbc-news`, `/hacker-news`, `/slashdot` - each of these show articles from a their specific news source
   * These routes use `IndexController@bbcNews`, `IndexController@hackerNews`, `IndexController@slashdot`

### Database & Models
I used `migrations` to create the following tables for the `news_scraper` database:
* `bbc_news_articles`
* `hacker_news_articles`
* `slashdot_articles`

After creating migrations the for each table, I created Eloquent Models to easily store and retrieve records from the database:
* `BBCNewsArticle`
* `HackerNewsArticle`
* `SlashdotArticle`

### Services
I decided to use Services to separate my code and make it reusable in the future.
 * This is also shown by the way I have the two different routing methods to view articles but still using the existing Services to retrieve articles
 * Services also allows tests to be easily written for each method
 * Each Service has an Interface that allows it to be injected where required  
  
#### `NewsScraperService`
This service uses the individual news source services (`BBCNewsService`, `HackerNewsService`, `SlashDotCrawlerService`) to retrieve articles from each source

It then returns an array of all the retrieved data

#### `BBCNewsService`
As the data from BBC News is consumed as an RSS Feed, I decided to use the following to read the data:
* `https://github.com/awjudd/l4-feed-reader`

The data retrieved contained a `raw_data` attribute that contained all the article data

This data was in an XML format so I used the following to parse the data: 
* `https://github.com/nathanmac/Parser`

Once parsed I looped through each of the articles and did the following:
* Use the URL of each article (`link`) and checked if it already existed in the database
* If it didn't then I add the article to the database

When all articles have been looped through I return all articles from the database

#### `HackerNewsService`
The Hacker News articles were retrieved using their API

Their API exposed endpoints that returned `JSON`

I had to use two endpoints to retrieve articles:
 * The first was to retrieve IDs of recent articles
 * The second endpoint was to get the article data by specifying an ID

Like the `BBCNewsService`, I also check the IDs of the articles retrieved from the API and compare them with the IDs of the articles in the database and only retrieve articles for those that don't exist in the database

Once the new articles are stored in the database, I return an array of all the articles 


#### `SlashdotCrawlerService`
The articles from `http://slashdot.org` had to be retrieved my crawling the site so I used the following to help me:
* `https://github.com/dweidner/laravel-goutte`

Once the site had been crawled, I used the `filter` method to extract content by passing it class names

I created an array of recent articles scraped from the site and compared the articles using the article `url` to see which articles are already in the database

I added the articles that don't exist in the database and returned an array of all the articles

## Frontend
### Views
I used Laravel's `blade` templates to render views, using partials and includes so sections can be reused

### Javascript
I used Bootstrap 4 to create the tabbed views

No other JS was required

### CSS 
I decided to use SCSS as it came with the new installation of the Laravel project 

I used Bootstrap 4 to create the 'cards' for each article 

Media queries was added for basic responsiveness

### Compile
Webpack / Mix was used to compile assets 

## Improvements
* I would have liked to have create this project in a TDD way, however, I did not have enough time to do this
* I created a specific Service for Slashdot, would have been better to create a generic `WebCrawlerService` that crawled any site with a set of defined parameters
* Instead of loading all the articles at once, to improve loading time, it would've been better to lazy load each article using AJAX
* Also would've improved the logic to calculate which articles exist in the database and which new ones to get
 
