<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ADMIN_ROLE = 1;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['email', 'password'];

    public function isAdmin()
    {
        return $this->role == self::ADMIN_ROLE;
    }

    public function talks()
    {
        return $this->hasMany('Talk', 'author_id');
        /* @todo can we do this somehow?
            ->orderBy(function ($talk) {
                return strtolower($talk->current()->title);
            });
        */
    }

    public function bios()
    {
        return $this->hasMany('Bio')->orderBy('nickname');
    }

    public function conferences()
    {
        return $this->hasMany('conference', 'author_id');
    }

    public function favoritedConferences()
    {
        return $this->belongstoMany('Conference', 'favorites')->withTimestamps();
    }

    // Cascade deletes
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
             $user->talks()->delete();
             // $user->conferences()->delete(); // Not sure if we want to do this.
             $user->bios()->delete();
             \DB::table('favorites')->where('user_id', $user->id)->delete();
        });
    }
}
