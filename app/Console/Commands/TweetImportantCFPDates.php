<?php

namespace App\Console\Commands;

use App\Models\Conference;
use Atymic\Twitter\Twitter;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TweetImportantCFPDates extends Command
{
    protected $name = 'tweet:cfpDates';

    protected $description = 'Send out a tweet with important upcoming CFP dates.';

    public function __construct(Twitter $twitter, $tweetWaitSeconds = 30)
    {
        $this->twitter = $twitter;
        $this->tweetWaitSeconds = $tweetWaitSeconds;

        parent::__construct();
    }

    public function handle()
    {
        $this->tweetCfpsOpeningToday();
        $this->tweetCfpsClosingTomorrow();
    }

    private function tweetCfpsOpeningToday()
    {
        $conferences = Conference::cfpOpeningToday()->get();

        $this->tweetable($conferences)->each(function ($conference) {
            $this->tweet($this->cfpOpensTodayMessage($conference));
            sleep($this->tweetWaitSeconds);
        });
    }

    private function tweetCfpsClosingTomorrow()
    {
        $conferences = Conference::cfpClosingTomorrow()->get();

        $this->tweetable($conferences)->each(function ($conference) {
            $this->tweet($this->cfpClosesTomorrowMessage($conference));
            sleep($this->tweetWaitSeconds);
        });
    }

    /**
     * Creates the message for a tweet about a CFP that opens today.
     *
     * 140 characters - 22 for the link, but bring back 4 for the two %s
     */
    private function cfpOpensTodayMessage($conference)
    {
        $message = 'CFP opens today for [%s] %s';
        $availableChars = 140 - 22 + 4 - strlen($message);

        $title = $this->shortenForTwitter($conference->title, $availableChars);

        return sprintf(
            $message,
            $title,
            $conference->link
        );
    }

    /**
     * Creates the message for a tweet about a CFP that closes tomorrow.
     *
     * 140 characters - 22 for the link, but bring back 4 for the two %s
     */
    private function cfpClosesTomorrowMessage($conference)
    {
        $message = 'CFP closes tomorrow for [%s] %s';
        $availableChars = 140 - 22 + 4 - strlen($message);

        $title = $this->shortenForTwitter($conference->title, $availableChars);

        return sprintf(
            $message,
            $title,
            $conference->link
        );
    }

    private function shortenForTwitter($message, $available)
    {
        return substr($message, 0, $available);
    }

    private function tweet($message)
    {
        try {
            $this->twitter->postTweet([
                'status' => $message,
            ]);

            Log::info('Successfully tweeted: ' . $message);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Retrieve only those conferences which should be tweeted.
     *
     * @param \Illuminate\Database\Eloquent\Collection $conferences
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function tweetable($conferences)
    {
        return $conferences->reject(function ($conference) {
            if (! $conference->starts_at || ! $conference->ends_at) {
                return true;
            }

            return $conference->cfp_starts_at->isSameDay($conference->cfp_ends_at);
        });
    }
}
