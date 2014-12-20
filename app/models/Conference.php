<?php

class Conference extends UuidBase
{
	protected $table = 'conferences';

	protected $guarded = array(
		'id'
	);

	public static $rules = array();

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }
}
