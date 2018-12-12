<?php

return [

    /*
     * To work with Twitter's Streaming API you'll need some credentials.
     *
     * If you don't have credentials yet, head over to https://apps.twitter.com/
     */

    'access_token' => env('TWITTER_ACCESS_TOKEN'),

    'access_token_secret' => env('TWITTER_ACCESS_SECRET'),

    'consumer_key' => env('TWITTER_ID'),

    'consumer_secret' => env('TWITTER_SECRET'),
];
