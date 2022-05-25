<?php

namespace App\Models;

use App\Models\TalkReaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends UuidBase
{
    use HasFactory;

    const RESPONSES = [
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

    public function talkRevision()
    {
        return $this->belongsTo(TalkRevision::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function acceptance()
    {
        return $this->belongsTo(Acceptance::class);
    }

    public function rejection()
    {
        return $this->belongsTo(Rejection::class);
    }

    public function reactions()
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
        $this->save();
    }

    public function isAccepted()
    {
        return $this->acceptance_id !== null;
    }

    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejection_id');
    }

    public function removeRejection()
    {
        $this->rejection_id = null;
        $this->save();
    }

    public function recordRejection(Rejection $rejection)
    {
        $this->rejection_id = $rejection->id;
        $this->save();
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
}
