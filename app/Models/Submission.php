<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends UuidBase
{
    use HasFactory;

    public const RESPONSES = [
        'acceptance' => Acceptance::class,
        'rejection' => Rejection::class,
    ];

    protected $table = 'submissions';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'talk_revision_id',
        'conference_id',
    ];

    public function talkRevision(): BelongsTo
    {
        return $this->belongsTo(TalkRevision::class);
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function acceptance(): BelongsTo
    {
        return $this->belongsTo(Acceptance::class);
    }

    public function rejection(): BelongsTo
    {
        return $this->belongsTo(Rejection::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(TalkReaction::class);
    }

    public function scopeAccepted($query)
    {
        return $query->whereNotNull('acceptance_id');
    }

    public function removeAcceptance()
    {
        $this->acceptance_id = null;
        $this->save();
    }

    public function recordAcceptance(Acceptance $acceptance)
    {
        $this->acceptance_id = $acceptance->id;
        $this->rejection_id = null;
        $this->save();

        Rejection::where('talk_revision_id', $this->talk_revision_id)
            ->delete();
    }

    public function isAccepted()
    {
        return $this->acceptance_id !== null;
    }

    public function scopeRejected($query)
    {
        $query->whereNotNull('rejection_id');
    }

    public function scopeWhereNotRejected($query)
    {
        $query->whereNull('rejection_id');
    }

    public function scopeWhereFuture($query)
    {
        $query->whereHas('conference', function ($query) {
            $query->future();
        });
    }

    public function removeRejection()
    {
        $this->rejection_id = null;
        $this->save();
    }

    public function recordRejection(Rejection $rejection)
    {
        $this->rejection_id = $rejection->id;
        $this->acceptance_id = null;
        $this->save();

        Acceptance::where('talk_revision_id', $this->talk_revision_id)
            ->delete();
    }

    public function isRejected()
    {
        return $this->rejection_id !== null;
    }

    public function getReasonAttribute()
    {
        return data_get($this, 'acceptance.reason') ??
            data_get($this, 'rejection.reason');
    }

    public function addReaction($url)
    {
        $this->reactions()->create([
            'url' => $url,
        ]);
    }

    public function author()
    {
        return data_get($this, 'talkRevision.talk.author');
    }

    public function getResponseAttribute()
    {
        if ($this->acceptance) {
            return 'acceptance';
        }

        if ($this->rejection) {
            return 'rejection';
        }
    }

    public function getResponseReasonAttribute()
    {
        if ($this->acceptance) {
            return $this->acceptance->reason;
        }

        if ($this->rejection) {
            return $this->rejection->reason;
        }
    }

    public function firstOrCreateResponse($type)
    {
        return $this->$type ??
            Submission::RESPONSES[$type]::createFromSubmission($this);
    }
}
