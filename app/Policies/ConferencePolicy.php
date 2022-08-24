<?php

namespace App\Policies;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConferencePolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Conference $conference)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $conference->author_id == $user->id;
    }
}
