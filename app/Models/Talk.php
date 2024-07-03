<?php

namespace App\Models;

use App\Collections\TalksCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Talk extends UuidBase
{
    use HasFactory;

    public static $rules = [];

    protected $table = 'talks';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'public' => 'boolean',
        'is_archived' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (self $talk) {
            $talk->revisions()->delete();
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_archived', false);
        });
    }

    public function newCollection(array $models = [])
    {
        return new TalksCollection($models);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function submissions(): HasManyThrough
    {
        return $this->hasManyThrough(Submission::class, TalkRevision::class);
    }

    public function acceptances(): HasManyThrough
    {
        return $this->hasManyThrough(Acceptance::class, TalkRevision::class);
    }

    public function currentRevision(): BelongsTo
    {
        return $this->belongsTo(TalkRevision::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(TalkRevision::class);
    }

    public function getRevisionsAttribute()
    {
        return $this->revisions()->getQuery()->orderBy('created_at', 'desc')->get();
    }

    public function isArchived()
    {
        return $this->is_archived;
    }

    public function archive()
    {
        $this->is_archived = true;
        $this->save();
    }

    public function restore()
    {
        $this->is_archived = false;
        $this->save();
    }

    public function scopePublic($query)
    {
        return $query->where('public', true);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeSubmitted($query)
    {
        $query->has('submissions');
    }

    public function scopeAccepted($query)
    {
        $query->has('acceptances');
    }

    public function scopeWithCurrentRevision($query)
    {
        $query->addSelect([
            'current_revision_id' => TalkRevision::select('id')
                ->whereColumn('talk_id', 'talks.id')
                ->latest()
                ->take(1),
        ])->with('currentRevision');
    }

    public function loadCurrentRevision()
    {
        return $this->setRelation(
            'currentRevision',
            TalkRevision::where('talk_id', $this->id)->latest()->take(1)->first(),
        );
    }

    public function getMySubmissionForConference(Conference $conference)
    {
        return $conference->mySubmissions()->filter(function ($item) {
            return $item->talkRevision->talk->id === $this->id;
        })->first();
    }

    public function getMyAcceptanceForConference(Conference $conference)
    {
        return $conference->myAcceptedTalks()->filter(function ($item) {
            return $item->talkRevision->talk->id === $this->id;
        })->first();
    }
}
