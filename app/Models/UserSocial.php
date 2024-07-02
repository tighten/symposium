<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    protected $table = 'users_social';

    protected $fillable = ['social_id', 'service'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
