<?php

namespace App\Models;

use App\Casts\Url;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conference extends UuidBase
{
    use HasFactory;

    protected $table = 'conferences';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'author_id',
        'title',
        'location',
        'latitude',
        'longitude',
        'description',
        'url',
        'cfp_url',
        'starts_at',
        'ends_at',
        'cfp_starts_at',
        'cfp_ends_at',
        'is_approved',
        'is_shared',
        'calling_all_papers_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cfp_starts_at' => 'datetime',
        'cfp_ends_at' => 'datetime',
        'is_approved' => 'boolean',
        'is_shared' => 'boolean',
        'author_id' => 'integer',
        'url' => Url::class,
        'cfp_url' => Url::class,    ];

    public static function boot()
    {
        parent::boot();

        // only approve conferences that are new imports
        self::creating(function ($conference) {
            if ($conference->calling_all_papers_id) {
                $conference->is_approved = true;
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function acceptances()
    {
        return $this->hasMany(Acceptance::class);
    }

    public function usersDismissed()
    {
        return $this->belongstoMany(User::class, 'dismissed_conferences')->withTimestamps();
    }

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

    public function scopeWhereAfter($query, Carbon $date)
    {
        $query->where('starts_at', '>', $date);
    }

    public function scopeOpenCfp($query)
    {
        return $query
            ->where('cfp_starts_at', '<=', Carbon::now())
            ->where('cfp_ends_at', '>', Carbon::now());
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeUndismissed($query)
    {
        return $query
            ->whereDoesntHave('usersDismissed', function ($query) {
                $query->where('id', auth()->id());
            });
    }

    public function scopeNotShared($query)
    {
        return $query->where('is_shared', false);
    }

    public function scopeWhereFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeWhereHasDates($query)
    {
        $query->whereNotNull(['starts_at', 'ends_at']);
    }

    public function scopeWhereHasCfpStart($query)
    {
        $query->whereNotNull('cfp_starts_at');
    }

    public function scopeWhereHasCfpEnd($query)
    {
        $query->whereNotNull('cfp_ends_at');
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

    public function getLinkAttribute()
    {
        return route('conferences.show', $this->id);
    }

    public function getEventDatesDisplayAttribute()
    {
        if (! $this->starts_at) {
            return null;
        }

        if (! $this->ends_at || $this->starts_at->isSameDay($this->ends_at)) {
            return $this->starts_at->format('M j Y');
        }

        return $this->starts_at->format('M j Y') . ' - ' . $this->ends_at->format('M j Y');
    }

    public function isDismissed()
    {
        return auth()->user()->dismissedConferences->contains($this->id);
    }

    public function isFavorited()
    {
        return auth()->user()->favoritedConferences->contains($this->id);
    }

    /**
     * Return all talks from this user that were submitted to this conference
     */
    public function mySubmissions()
    {
        $talks = auth()->user()->talks;

        return $this->submissions->filter(function ($submission) use ($talks) {
            return $talks->contains($submission->talkRevision->talk);
        });
    }

    /**
     * Return all talks from this user that were accepted to this conference
     */
    public function myAcceptedTalks()
    {
        $talks = auth()->user()->talks;

        return $this->acceptances->filter(function ($acceptance) use ($talks) {
            return $talks->contains($acceptance->talk);
        });
    }

    public function appliedTo()
    {
        return $this->mySubmissions()->count() > 0;
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

    private function hasAnnouncedCallForProposals()
    {
        return (! is_null($this->cfp_starts_at)) && (! is_null($this->cfp_ends_at));
    }
}
