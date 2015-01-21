<?php

use Carbon\Carbon;

class Conference extends UuidBase
{
    protected $table = 'conferences';

    protected $guarded = array(
        'id'
    );

    protected $dates = [
        'starts_at',
        'ends_at',
        'cfp_starts_at',
        'cfp_ends_at'
    ];

    public static $rules = [];

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    public static function closingSoonest()
    {
        $hasOpenCfp = self::whereNotNull('cfp_ends_at')
            ->where('cfp_ends_at', '>', Carbon::now())
            ->orderBy('cfp_ends_at', 'ASC')
            ->get();
        $hasNoCfp = self::whereNull('cfp_ends_at')
            ->whereNotNull('starts_at')
            ->orderBy('starts_at' ,'ASC')
            ->get();
        $hasNoCfpOrConf = self::whereNull('cfp_ends_at')
            ->whereNull('starts_at')
            ->orderBy('title')
            ->get();
        $hasExpiredCfp = self::whereNotNull('cfp_ends_at')
            ->where('cfp_ends_at', '<=', Carbon::now())
            ->orderBy('cfp_ends_at', 'ASC')
            ->get();

        $return = $hasOpenCfp
            ->merge($hasNoCfp)
            ->merge($hasNoCfpOrConf)
            ->merge($hasExpiredCfp);

        return $return;
    }

    public function cfpIsOpen()
    {
        return $this->isCurrentlyAcceptingProposals();
    }

    public function isCurrentlyAcceptingProposals()
    {
        if (! $this->hasAnnouncedCallForProposals()) {
            return false;
        }

        return Carbon::today()->between($this->getAttribute('cfp_starts_at'), $this->getAttribute('cfp_ends_at'));
    }

    private function hasAnnouncedCallForProposals()
    {
        return (! is_null($this->cfp_starts_at)) && (! is_null($this->cfp_ends_at));
    }

    /**
     * Get all users who favorited this conference
     */
    public function usersFavorited()
    {
        return $this->belongstoMany('User', 'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        return \Auth::user()->favoritedConferences->contains($this->id);
    }


    public function startsAtDisplay()
    {
        return $this->startsAtSet() ? $this->starts_at->toFormattedDateString() : '[Date not set]';
    }

    public function endsAtDisplay()
    {
        return $this->endsAtSet() ? $this->ends_at->toFormattedDateString() : '[Date not set]';
    }

    public function cfpStartsAtDisplay()
    {
        return $this->cfpStartsAtSet() ? $this->cfp_starts_at->toFormattedDateString() : '[Date not set]';
    }

    public function cfpEndsAtDisplay()
    {
        return $this->cfpEndsAtSet() ? $this->cfp_ends_at->toFormattedDateString() : '[Date not set]';
    }



    public function startsAtSet()
    {
        return $this->starts_at;
    }

    public function endsAtSet()
    {
        return $this->ends_at;
    }

    public function cfpStartsAtSet()
    {
        return $this->cfp_starts_at;
    }

    public function cfpEndsAtSet()
    {
        return $this->cfp_ends_at;
    }
}
