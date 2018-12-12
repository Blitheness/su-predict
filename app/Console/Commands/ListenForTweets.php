<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TwitterStreamingApi;

class ListenForTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for game tweets on Twitter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        TwitterStreamingApi::publicStream()
            ->whenHears('#' . env('TWITTER_LISTEN_HASHTAG'), function (array $tweet) {
                $content = $tweet['text'];
                $userId  = $tweet['id_str'];
                dump("Twitter user {$userId} posted {$content}");
                // @TODO Fire an event
            })
            ->startListening();
    }
}
