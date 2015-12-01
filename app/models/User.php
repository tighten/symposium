<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    const ADMIN_ROLE = 1;

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['email', 'password'];

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Returns whether user has admin role
     *
     * Hacky role system for now
     *
     * @return bool
     */
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
}
