<?php

Route::get('/', 'IndexController@index');
Route::get('/bbc-news', 'IndexController@bbcNews');
Route::get('/hacker-news', 'IndexController@hackerNews');
Route::get('/slashdot', 'IndexController@slashdot');