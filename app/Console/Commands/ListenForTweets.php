<?php

namespace App\Console\Commands;

use App\GameEntry;
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
                $userId  = $tweet['user']['id_str'];
                dump("Twitter user {$userId} posted {$content}");
                // @TODO Fire an event
                $pattern = "/#" . env('TWITTER_LISTEN_HASHTAG') . " ([A-Za-z ]+): ([0-9]+)%; ([[:punct:]A-Za-z ]+): ([0-9]+)%; put it on page ([0-9]+)/i";
                preg_match($pattern, $content, $matches);
                // Index   - Value
                // 1         Outcome 1 name
                // 2         Outcome 1 value (%)
                // 3         Outcome 2 name
                // 4         Outcome 2 value (%)
                // 5         Put it on page ...
                if(null != $matches && is_array($matches) && count($matches)==6) {
                    GameEntry::create([
                        'twitter_id'       => $userId,
                        'outcome_1'        => $matches[1],
                        'outcome_1_value'  => $matches[2],
                        'outcome_2'        => $matches[3],
                        'outcome_2_value'  => $matches[4],
                        'page'             => $matches[5]
                    ]);
                } else {
                    dump("Formatting error");
                }
            })
            ->startListening();
    }
}
