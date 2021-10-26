<?php

namespace App;

class Talk extends UuidBase
{
    public static $rules = [];

    protected $table = 'talks';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'public' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function submissions()
    {
        return $this->hasManyThrough(Submission::class, TalkRevision::class);
    }

    public function current()
    {
        return $this->revisions()->orderBy('created_at', 'DESC')->first();
    }

    public function revisions()
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

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeSubmitted($query)
    {
        $query->has('submissions');
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

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (self $talk) {
            $talk->revisions()->delete();
        });
    }
}
