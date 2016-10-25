<?php

class TalkRevision extends UuidBase
{
    protected $title;
    protected $type;
    protected $length;
    protected $level;
    protected $description;
    protected $slides;
    protected $organizer_notes;

    protected $table = 'talk_revisions';

    protected $guarded = [
        'id'
    ];

    public static $rules = [];

    public function talk()
    {
        return $this->belongsTo('App\Models\Talk');
    }

    public function getUrl()
    {
        return '/talks/' . $this->talk->id . '/?revision=' . $this->id;
    }

    public function getHtmledDescription()
    {
        return $this->htmlize($this->getAttribute('description'));
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
