<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Laravel\Scout\Searchable;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Searchable;

    const ADMIN_ROLE = 1;
    const PROFILE_PICTURE_THUMB_PATH = 'profile_pictures/thumbs/';
    const PROFILE_PICTURE_HIRES_PATH = 'profile_pictures/hires/';

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['email', 'password', 'name'];

    public function scopeWantsNotifications($query)
    {
        return $query->where('wants_notifications', true);
    }

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

    public function dismissedConferences()
    {
        return $this->belongstoMany(Conference::class, 'dismissed_conferences')->withTimestamps();
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

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'location' => $this->location,
            'neighborhood' => $this->neighborhood,
            'sublocality' => $this->sublocality,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ];
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
                Storage::delete(self::PROFILE_PICTURE_THUMB_PATH . $user->profile_picture);
                Storage::delete(self::PROFILE_PICTURE_HIRES_PATH . $user->profile_picture);
            }

            DB::table('favorites')->where('user_id', $user->id)->delete();
            DB::table('dismissed_conferences')->where('user_id', $user->id)->delete();
        });
    }

    public function social()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function hasSocialLinked($service)
    {
        return (bool) $this->social->where('service', $service)->count();
    }
}
