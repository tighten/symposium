<?php

class Talk extends Eloquent
{
	protected $table = 'talks';

	protected $guarded = array(
		'id'
	);

	public static $rules = array();

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }
}
