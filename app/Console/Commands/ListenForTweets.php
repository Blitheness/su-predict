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
                $pattern = "/#" . env('TWITTER_LISTEN_HASHTAG') . " (([[:punct:]A-Za-z ]+:? [0-9]+%;?)+).*page ?([0-9]+)/i";
                $pattern2 = "/([A-Za-z0-9][[:punct:]A-Za-z ]+):? ([0-9]+)%;?/";
                preg_match($pattern, $content, $matches);
                // Index   - Value
                // 1         Outcome 1 name
                // 2         Outcome 1 value (%)
                // 3         Outcome 2 name
                // 4         Outcome 2 value (%)
                // 5         Put it on page ...
                if(null != $matches && is_array($matches) && count($matches)>2) {
                    $matches2 = [];
                    preg_match_all($pattern2, $matches[1], $matches2);
                    if(null != $matches2 && is_array($matches2) && count($matches2)>1 && is_array($matches2[0])) {
                        $entry = GameEntry::create([
                            'twitter_id'       => $userId,
                            'page'             => $matches[3]
                        ]);
                        $count = count($matches2[0]);
                        $i = 0;
                        for($i = 0; $i<$count; $i++) {
                            $outcome = $matches2[1][$i];
                            $outcome = substr($outcome, -1)==':' ? substr($outcome, 0, -1) : $outcome;
                            $value   = $matches2[2][$i];
                            $entry->options()->create([
                                'outcome' => $outcome,
                                'value'   => $value
                            ]);
                            dump("{$outcome}: {$value}%");
                        }
                    } else {
                        dump("Options formatting error");
                    }
                } else {
                    dump("Tweet format error");
                }
            })
            ->startListening();
    }
}
