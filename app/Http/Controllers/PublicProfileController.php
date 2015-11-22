<?php

namespace Symposium\Http\Controllers;

use Symposium\Http\Controllers\Controller;
use User;

class PublicProfileController extends Controller
{
    public function index()
    {
        $users = User::where('enable_profile', true)
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();

        return view('account.public-profile.index')
            ->with('speakers', $users);
    }

    public function show($profile_slug)
    {
        $user = User::where('profile_slug', $profile_slug)
            ->where('enable_profile', true)
            ->firstOrFail();

        $talks = $user->talks->sortBy(function ($talk) {
            return ($talk->title);
        });

        return view('account.public-profile.show')
            ->with('user', $user)
            ->with('talks', $talks);
    }

    public function showTalk($profile_slug, $talk_id)
    {
        $user = User::where('profile_slug', $profile_slug)
            ->where('enable_profile', true)
            ->firstOrFail();

        $talk = $user->talks()->findOrFail($talk_id);

        return view('talks.show-public')
            ->with('user', $user)
            ->with('talk', $talk);
    }

    public function getEmail($profile_slug)
    {
        $user = User::where('profile_slug', $profile_slug)
            ->where('enable_profile', true)
            ->firstOrFail();

        return view('account.public-profile.email')
            ->with('user', $user);
    }

    public function postEmail()
    {
        dd("send email");
    }
}
