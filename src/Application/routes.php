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
                Route::get('/accounts', 'TwitterAccountController@getAll');
                Route::post('/accounts', 'TwitterAccountController@post');

                Route::get('/accounts/{id}', 'TwitterAccountController@getOne');
                Route::patch('/accounts/{id}', 'TwitterAccountController@patch');
                Route::delete('/accounts/{id}', 'TwitterAccountController@delete');

                Route::get('/accounts/{id}/statistics', 'AccountStatisticsController@getByAccountId');
                Route::get('/accounts/{id}/tweets', 'TweetController@getAllByAccountId');

                Route::get('/tweets', 'TweetController@getAll');
                Route::get('/tweets/{id}', 'TweetController@getOne');
                Route::get('/tweets/{id}/statistics', 'TweetStatisticsController@getByTweetId');
            }
        );
    }
);

