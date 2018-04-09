<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->namespace('CoenMooij\BrandApi\Application\Authentication')->group(
    function () {
        Route::post('/login', 'AuthenticationController@login');
        Route::post('/register', 'AuthenticationController@register');
        Route::post('/resetPassword', 'AuthenticationController@resetPassword');
        Route::get('/logout', 'AuthenticationController@logout')->middleware('auth');
    }
);

Route::middleware('auth')->group(
    function () {
        Route::prefix('twitter')->namespace('CoenMooij\BrandApi\Application\Twitter')->group(
            function () {
                Route::get('/twitter-accounts', 'TwitterAccountController@getAll');
                Route::post('/twitter-accounts', 'TwitterAccountController@post');

                Route::get('/twitter-accounts/{id}', 'TwitterAccountController@getOne');
                Route::patch('/twitter-accounts/{id}', 'TwitterAccountController@patch');
                Route::delete('/twitter-accounts/{id}', 'TwitterAccountController@delete');

                Route::get('/twitter-accounts/{id}/statistics', 'AccountStatisticsController@getByAccountId');
                Route::get('/twitter-accounts/{id}/tweets', 'TweetController@getAllByAccountId');

                Route::get('/tweets', 'TweetController@getAll');
                Route::get('/tweets/{id}', 'TweetController@getOne');
                Route::get('/tweets/{id}/statistics', 'TweetStatisticsController@getByTweetId');
            }
        );
    }
);

