<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class User extends Authenticatable
{
    const ADMIN_ROLE = 1;
    const PROFILE_PICTURE_THUMB_PATH = 'profile_pictures/thumbs/';
    const PROFILE_PICTURE_HIRES_PATH = 'profile_pictures/hires/';

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['email', 'password', 'name'];

    public function isAdmin()
    {
        return $this->role == self::ADMIN_ROLE;
    }

    public function talks()
    {
        return $this->hasMany(Talk::class, 'author_id');
    }

    public function activeTalks()
    {
        return $this->hasMany(Talk::class, 'author_id')->where('is_archived', false);
    }

    public function getTalksAttribute()
    {
        return $this->talks()->get()->sortBy(function ($talk) {
            return strtolower($talk->current()->title);
        })->values();
    }

    public function getActiveTalksAttribute()
    {
        return $this->activeTalks()->get()->sortBy(function ($talk) {
            return strtolower($talk->current()->title);
        })->values();
    }

    public function bios()
    {
        return $this->hasMany(Bio::class)->orderBy('nickname');
    }

    public function conferences()
    {
        return $this->hasMany(Conference::class, 'author_id');
    }

    public function favoritedConferences()
    {
        return $this->belongstoMany(Conference::class, 'favorites')->withTimestamps();
    }

    public function updateProfilePicture($filename)
    {
        $this->profile_picture = $filename;
        return $this->save();
    }

    public function getProfilePictureThumbAttribute()
    {
        if (! $this->profile_picture) {
            return Gravatar::src($this->email, 50);
        }

        return asset('/storage/' . self::PROFILE_PICTURE_THUMB_PATH . $this->profile_picture);
    }

    public function getProfilePictureHiresAttribute()
    {
        if (! $this->profile_picture) {
            return Gravatar::src($this->email, 500);
        }

        return asset('/storage/' . self::PROFILE_PICTURE_HIRES_PATH . $this->profile_picture);
    }

    protected static function boot()
    {
        parent::boot();

        // Cascade deletes
        static::deleting(function ($user) {
            $user->talks()->delete();
            // $user->conferences()->delete(); // Not sure if we want to do this.
            $user->bios()->delete();

            if ($user->profile_picture && strpos($user->profile_picture, '/') === false) {
                Storage::delete(User::PROFILE_PICTURE_THUMB_PATH . $user->profile_picture);
                Storage::delete(User::PROFILE_PICTURE_HIRES_PATH . $user->profile_picture);
            }

            \DB::table('favorites')->where('user_id', $user->id)->delete();
        });
    }
}
