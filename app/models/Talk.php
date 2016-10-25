<?php

class Talk extends UuidBase
{
    protected $table = 'talks';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'public' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public static $rules = [];

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

//    public function submissions()
//    {
//        return $this->belongsToMany('App\Models\Conference');
//    }

    public function current()
    {
        return $this->revisions()->orderBy('created_at', 'DESC')->first();
    }

    public function revisions()
    {
        return $this->hasMany('TalkRevision');
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
}
