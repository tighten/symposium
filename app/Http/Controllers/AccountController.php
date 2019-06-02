<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AccountController extends BaseController
{
    const THUMB_SIZE = 250;
    const HIRES_SIZE = 1250;

    public function show()
    {
        return view('account.show')
            ->with('user', Auth::user());
    }

    public function edit()
    {
        return view('account.edit')
            ->with('user', Auth::user());
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users,email,' . Auth::user()->id,
            'wants_notifications' => '',
            'enable_profile' => '',
            'allow_profile_contact' => '',
            'profile_intro' => '',
            'profile_slug' => 'alpha_dash|required_if:enable_profile,1|unique:users,profile_slug,' . Auth::user()->id,
            'profile_picture' => 'image|max:5000',
        ], [
            'profile_picture.max' => 'Profile picture cannot be larger than 5mb',
            'profile_slug.required_if' => 'You must set a Profile URL Slug to enable your Public Speaker Profile',
        ]);

        // Save
        $user = Auth::user();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->get('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->wants_notifications = $request->get('wants_notifications');
        $user->enable_profile = $request->get('enable_profile');
        $user->allow_profile_contact = $request->get('allow_profile_contact');
        $user->profile_intro = $request->get('profile_intro');
        $user->profile_slug = $request->get('profile_slug');
        $user->location = $request->get('location');
        $user->neighborhood = $request->get('neighborhood');
        $user->sublocality = $request->get('sublocality');
        $user->city = $request->get('city');
        $user->state = $request->get('state');
        $user->country = $request->get('country');

        $user->save();

        if ($request->hasFile('profile_picture')) {
            $this->updateProfilePicture($user, $request->file('profile_picture'));
        }

        Session::flash('message', 'Successfully edited account.');

        return redirect('account');
    }

    private function updateProfilePicture($user, $picture)
    {
        // Make regular image
        $thumb = Image::make($picture->getRealPath())
            ->fit(self::THUMB_SIZE, self::THUMB_SIZE);

        // Make hires image
        $hires = Image::make($picture->getRealPath())
            ->fit(self::HIRES_SIZE, self::HIRES_SIZE, function ($constraint) {
                $constraint->upsize();
            });

        // Delete the previous profile pictures
        if ($user->profile_picture != null) {
            Storage::delete([
                User::PROFILE_PICTURE_THUMB_PATH . $user->profile_picture,
                User::PROFILE_PICTURE_HIRES_PATH . $user->profile_picture
            ]);
        }

        // Store the new profile pictures
        Storage::put(User::PROFILE_PICTURE_THUMB_PATH . $picture->hashName(), $thumb->stream());
        Storage::put(User::PROFILE_PICTURE_HIRES_PATH . $picture->hashName(), $hires->stream());

        // Save the updated filename to the user
        $user->updateProfilePicture($picture->hashName());
    }

    public function delete()
    {
        return view('account.confirm-delete');
    }

    public function destroy()
    {
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        Session::flash('message', 'Successfully deleted account.');

        return redirect('/');
    }

    public function export(Filesystem $storage)
    {
        $user = Auth::user();
        $user->load('talks.revisions');

        $headers = ['Content-type' => 'application/json'];

        $tempName = sprintf('%d_export.json', $user->id);
        $exportName = sprintf('export_%s.json', date('Y_m_d'));

        $export = ['talks' => $user->talks->toArray()];

        $storage
            ->disk('local')
            ->put($tempName, json_encode($export));

        $path = storage_path() . '/app/';

        return response()
            ->download($path . $tempName, $exportName, $headers)
            ->deleteFileAfterSend(true);
    }

    public function oAuthSettings()
    {
        return view('account.oauth-settings');
    }
}
