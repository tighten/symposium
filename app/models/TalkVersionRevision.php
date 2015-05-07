<?php

class TalkVersionRevision extends UuidBase
{
    protected $title;
    protected $type;
    protected $length;
    protected $level;
    protected $description;
    protected $outline;
    protected $organizer_notes;

    protected $table = 'talk_version_revisions';

    protected $guarded = [
        'id'
    ];

    public static $rules = array();

    public function talkVersion()
    {
        return $this->belongsTo('TalkVersion');
    }

    public function getTalkAttribute()
    {
        return $this->talkVersion->talk;
    }

    public function getUrl()
    {
        return '/talks/' . $this->getAttribute('talk')->id . '/versions/' . $this->talkVersion->id . '/' . $this->id;
    }

    public function getHtmledDescription()
    {
        return $this->htmlize($this->getAttribute('description'));
    }

    public function getHtmledOutline()
    {
        return $this->htmlize($this->getAttribute('outline'));
    }

    public function getHtmledOrganizerNotes()
    {
        return $this->htmlize($this->getAttribute('organizer_notes'));
    }

    private function htmlize($string)
    {
        if ($string == '') {
            return '<i>(empty)</i>';
        }

        return str_replace("\n", "<br>", $string);
    }
}
