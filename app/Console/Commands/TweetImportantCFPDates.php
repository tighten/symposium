<?php namespace Symposium\Console\Commands;

use Carbon\Carbon;
use Conference;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Thujohn\Twitter\Twitter;

// @todo: Move the scopes into the conference model so we can re-use and test
class TweetImportantCFPDates extends Command
{
    protected $name = 'tweet:cfpDates';

    protected $description = 'Send out a tweet with important upcoming CFP dates.';

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;

        parent::__construct();
    }

    public function fire()
    {
        $this->tweetCfpsOpeningToday();
        $this->tweetCfpsClosingTomorrow();
    }

    private function tweetCfpsOpeningToday()
    {
        $conferences = Conference::where('cfp_starts_at', '>=', Carbon::now()->startOfDay())
            ->where('cfp_starts_at', '<=', Carbon::now()->endOfDay())
            ->get();

        $conferences->each(function($conference) {
            $this->tweet($this->cfpOpensTodayMessage($conference));
        });
    }

    private function tweetCfpsClosingTomorrow()
    {
        $conferences = Conference::where('cfp_ends_at', '>=', Carbon::now()->addDay()->startOfDay())
            ->where('cfp_ends_at', '<=', Carbon::now()->addDay()->endOfDay())
            ->get();

        $conferences->each(function($conference) {
            $this->tweet($this->cfpClosesTomorrowMessage($conference));
        });
    }

    /**
     * Creates the message for a tweet about a CFP that opens today
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
            $conference->publicUrl
        );
    }

   /**
     * Creates the message for a tweet about a CFP that closes tomorrow
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
            $conference->publicUrl
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
                'status' => $message
            ]);

            Log::info('Successfully tweeted: ' . $message);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        sleep(30); // OH SNAPP
    }
}
