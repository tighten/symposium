<?php

namespace Symposium\Http\Controllers;

use Captcha\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symposium\Http\Controllers\Controller;
use User;

class PublicProfileController extends Controller
{
    private function getPublicUserByProfileSlug($profile_slug)
    {
        return User::where('profile_slug', $profile_slug)
            ->where('enable_profile', true)
            ->firstOrFail();
    }

    public function index()
    {
        $users = User::where('enable_profile', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('account.public-profile.index')
            ->with('speakers', $users);
    }

    public function show($profile_slug)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        $talks = $user->talks()->public()->orderBy('title')->get();

        return view('account.public-profile.show')
            ->with('user', $user)
            ->with('talks', $talks);
    }

    public function showTalk($profile_slug, $talk_id)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        $talk = $user->talks()->findOrFail($talk_id);

        return view('talks.show-public')
            ->with('user', $user)
            ->with('talk', $talk);
    }

    public function getEmail($profile_slug)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        return view('account.public-profile.email')
            ->with('user', $user);
    }

    public function postEmail($profile_slug, Captcha $captcha, Request $request)
    {
        $user = $this->getPublicUserByProfileSlug($profile_slug);

        $this->validate($request, [
            'email' => 'required|email',
            'name' => '',
            'message' => 'required'
        ]);

        $captchaResponse = $captcha->check();
        if (! $captchaResponse->isValid()) {
            Log::error('Captcha error on public speaker profile page ' . $request->url() . '; reason: ' . $captchaResponse->getError());
            exit('You have not passed the captcha. Please try again.');
        }

        Mail::send('emails.public-profile-contact', ['email' => $request->get('email'), 'name' => $request->get('name'), 'userMessage' => $request->get('message')], function ($m) use ($user) {
            $m->from('noreply@symposiumapp.com', 'Symposium');

            $m->to($user->email, $user->name)->subject('Contact from your Symposium public profile page');
        });

        Session::flash('success-message', 'Message sent!');

        return redirect()->route('speakers-public.show', ['profile_slug' => $user->profile_slug]);
    }
}
