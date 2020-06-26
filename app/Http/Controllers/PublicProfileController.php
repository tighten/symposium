<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequest;
use App\User;
use Captcha\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PublicProfileController extends Controller
{
    public function index()
    {
        $users = User::where('enable_profile', true)
            ->whereNotNull('profile_slug')
            ->orderBy('name', 'asc')
            ->get();

        return view('account.public-profile.index', [
            'speakers' => $users,
        ]);
    }

    public function search(Request $request)
    {
        $users = User::search($request->get('query'))
            ->orderBy('name', 'asc')->get();

        // Since Scout searches can only perform rudimentary where clauses,
        // we must filter search results to only validly public profiles.
        $filteredUsers = $users->filter(function ($user) {
            return $user->enable_profile == true &&
                ! is_null($user->profile_slug);
        });

        return view('account.public-profile.index', [
            'speakers' => $filteredUsers,
            'query' => $request->get('query'),
        ]);
    }

    public function show($profile_slug)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        $talks = $user->talks()->public()->get()->sortBy(function ($talk) {
            return $talk->current()->title;
        });

        $bios = $user->bios()->public()->get();

        return view('account.public-profile.show', [
            'user' => $user,
            'talks' => $talks,
            'bios' => $bios,
        ]);
    }

    public function showTalk($profile_slug, $talk_id)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        $talk = $user->talks()->public()->findOrFail($talk_id);

        return view('talks.show-public', [
            'user' => $user,
            'talk' => $talk,
        ]);
    }

    public function showBio($profile_slug, $bio_id)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        $bio = $user->bios()->public()->findOrFail($bio_id);

        return view('bios.show-public', [
            'user' => $user,
            'bio' => $bio,
        ]);
    }

    public function getEmail($profile_slug)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        if (! $user->allow_profile_contact) {
            abort(404);
        }

        return view('account.public-profile.email', [
            'user' => $user,
        ]);
    }

    public function postEmail($profile_slug, Captcha $captcha, Request $request)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        if (! $user->allow_profile_contact) {
            abort(404);
        }

        $this->validate($request, [
            'email' => 'required|email',
            'name' => '',
            'message' => 'required',
        ]);

        $captchaResponse = $captcha->check();
        if (! $captchaResponse->isValid()) {
            Log::info('Captcha error on public speaker profile page ' . $request->url() . '; reason: ' . $captchaResponse->getError());
            exit('You have not passed the captcha. Please try again.');
        }

        Mail::to($user->email)->send(new ContactRequest($request->get('email'), $request->get('name'), $request->get('message')));

        Session::flash('success-message', 'Message sent!');

        return redirect()->route('speakers-public.show', $user->profile_slug);
    }

    private function getPublicUserByProfileSlug($profile_slug)
    {
        return User::where('profile_slug', $profile_slug)
            ->where('enable_profile', true)
            ->firstOrFail();
    }
}
