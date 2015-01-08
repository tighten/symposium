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

    public function cfpIsOpen()
    {
        if ($this->cfp_starts_at == null || $this->cfp_ends_at == null) return false;

        return Carbon::today()->between($this->getAttribute('cfp_starts_at'), $this->getAttribute('cfp_ends_at'));
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
        return $this->starts_at && $this->starts_at->format('Y') != '-0001';
    }

    public function endsAtSet()
    {
        return $this->ends_at && $this->ends_at->format('Y') != '-0001';
    }

    public function cfpStartsAtSet()
    {
        return $this->cfp_starts_at && $this->cfp_starts_at->format('Y') != '-0001';
    }

    public function cfpEndsAtSet()
    {
        return $this->cfp_ends_at && $this->cfp_ends_at->format('Y') != '-0001';
    }
}
