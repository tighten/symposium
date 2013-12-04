<?php

class Style extends Eloquent
{
	protected $table = 'styles';

	protected $guarded = array(
		'id'
	);

	public static $rules = array();

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    /* Eventually...
    public function comments()
    {
        return $this->hasMany('Comment');
    }

    public function votes()
    {
        return $this->hasMany('Vote');
    }
    */
}
