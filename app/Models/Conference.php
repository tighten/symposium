<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Conference extends UuidBase
{
    protected $table = 'conferences';

    protected $guarded = array(
        'id'
    );

    protected $fillable = [
        'author_id',
        'title',
        'description',
        'url',
        'cfp_url',
        'starts_at',
        'ends_at',
        'cfp_starts_at',
        'cfp_ends_at',
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
        'cfp_starts_at',
        'cfp_ends_at'
    ];

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    public function submissions()
    {
        return $this->belongsToMany(TalkRevision::class, 'submissions')->withTimestamps();
    }

//    public function submitters()
//    {
//        return $this->hasManyThrough(Talk::class', 'User');
//    }

    // @todo: Deprecate?
    public static function closingSoonest()
    {
        $hasOpenCfp = self::whereNotNull('cfp_ends_at')
            ->where('cfp_ends_at', '>', Carbon::now())
            ->orderBy('cfp_ends_at', 'ASC')
            ->get();
        $hasNoCfp = self::whereNull('cfp_ends_at')
            ->whereNotNull('starts_at')
            ->orderBy('starts_at', 'ASC')
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

    public function scopeCfpOpeningToday($query)
    {
        return $query
            ->where('cfp_starts_at', '>=', Carbon::now()->startOfDay())
            ->where('cfp_starts_at', '<=', Carbon::now()->endOfDay());
    }

    public function scopeCfpClosingTomorrow($query)
    {
        return $query
            ->where('cfp_ends_at', '>=', Carbon::now()->addDay()->startOfDay())
            ->where('cfp_ends_at', '<=', Carbon::now()->addDay()->endOfDay());
    }

    public function scopeUnclosedCfp($query)
    {
        return $query
            ->where('cfp_ends_at', '>', Carbon::now());
    }

    public function scopeFuture($query)
    {
        return $query
            ->where('starts_at', '>', Carbon::now());
    }

    public function scopeOpenCfp($query)
    {
        return $query
            ->where('cfp_starts_at', '<=', Carbon::now())
            ->where('cfp_ends_at', '>', Carbon::now());
    }

    /**
     * Whether CFP is currently open
     *
     * @deprecated
     * @return bool
     */
    public function cfpIsOpen()
    {
        return $this->isCurrentlyAcceptingProposals();
    }

    /**
     * Whether conference is currently accepted talk proposals
     *
     * @return bool
     */
    public function isCurrentlyAcceptingProposals()
    {
        if (! $this->hasAnnouncedCallForProposals()) {
            return false;
        }

        return Carbon::today()->between($this->getAttribute('cfp_starts_at'), $this->getAttribute('cfp_ends_at'));
    }

    /**
     * Whether conference has announced a call for proposals
     *
     * @return bool
     */
    private function hasAnnouncedCallForProposals()
    {
        return (! is_null($this->cfp_starts_at)) && (! is_null($this->cfp_ends_at));
    }

    public function getLinkAttribute()
    {
        return route('conferences.show', $this->id);
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
        return Auth::user()->favoritedConferences->contains($this->id);
    }

    /**
     * Return all talks from this user that were submitted to this conference
     *
     * @return Collection
     */
    public function myTalks()
    {
        $talks = Auth::user()->talks;

        return $this->submissions->filter(function ($talkRevision) use ($talks) {
            return $talks->contains($talkRevision->talk);
        });
    }

    public function appliedTo()
    {
        return $this->myTalks()->count() > 0;
    }

    public function startsAtDisplay()
    {
        return $this->startsAtSet() ? $this->starts_at->format('D M j, Y') : '[Date not set]';
    }

    public function endsAtDisplay()
    {
        return $this->endsAtSet() ? $this->ends_at->format('D M j, Y') : '[Date not set]';
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
