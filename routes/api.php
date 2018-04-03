<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/tweets/{id}/reach','ReachController@getReachForTweet');
