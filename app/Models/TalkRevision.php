<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalkRevision extends UuidBase
{
    use HasFactory;

    public static $rules = [];

    protected $title;

    protected $type;

    protected $length;

    protected $level;

    protected $description;

    protected $slides;

    protected $organizer_notes;

    protected $table = 'talk_revisions';

    protected $guarded = [
        'id',
    ];

    public function talk(): BelongsTo
    {
        return $this->belongsTo(Talk::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function getUrl()
    {
        return '/talks/' . $this->talk->id . '/?revision=' . $this->id;
    }

    public function getDescription()
    {
        return $this->htmlize($this->getAttribute('description'), false);
    }

    public function getHtmledOrganizerNotes()
    {
        return $this->htmlize($this->getAttribute('organizer_notes'));
    }

    private function htmlize($string, $changeNewLineToBR = true)
    {
        if ($string == '') {
            return '<i>(empty)</i>';
        }

        return $changeNewLineToBR ? str_replace('\n', '<br>', $string) : $string;
    }
}
