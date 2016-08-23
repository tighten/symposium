<?php namespace App\Http\Controllers;

use App\Events\ProfilePictureUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\User;
use Intervention\Image\Facades\Image;

class AccountController extends BaseController
{
    public function create()
    {
        return view('account.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'email' => 'email|required|unique:users,email',
            'enable_profile' => '',
            'allow_profile_contact' => '',
            'profile_intro' => '',
            'profile_slug' => 'alpha_dash|unique:users',
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        Event::fire('new-signup', [$user]);
        Auth::loginUsingId($user->id);

        Session::flash('message', 'Successfully created account.');

        return redirect('account');
    }

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
            'enable_profile' => '',
            'allow_profile_contact' => '',
            'profile_intro' => '',
            'profile_slug' => 'alpha_dash|required_if:enable_profile,1|unique:users,profile_slug,' . Auth::user()->id,
            'profile_picture' => 'image|max:5000',
        ], [
            'profile_picture.max' => 'Profile picture cannot be larger than 5mb',
            'profile_slug.required_if' => 'You must set a Profile URL Slug to enable your Public Speaker Profile'
        ]);

        // Save
        $user = Auth::user();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->get('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->enable_profile = $request->get('enable_profile');
        $user->allow_profile_contact = $request->get('allow_profile_contact');
        $user->profile_intro = $request->get('profile_intro');
        $user->profile_slug = $request->get('profile_slug');

        if ($request->file('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = $image->hashName();
            Event::fire(
                new ProfilePictureUpdated($user, $image->getRealPath(), $filename)
            );
        }

        $user->save();

        Session::flash('message', 'Successfully edited account.');

        return redirect('account');
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

    /**
     * @param \Illuminate\Contracts\Filesystem\Factory $storage
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(\Illuminate\Contracts\Filesystem\Factory $storage)
    {
        $user = Auth::user();
        $user->load('talks.revisions');

        $headers = ['Content-type' => 'application/json'];

        $tempName = sprintf('%d_export.json', $user->id);
        $exportName = sprintf('export_%s.json', date('Y_m_d'));

        $export = [
            'talks' => $user->talks->toArray()
        ];

        $storage
            ->disk('local')
            ->put($tempName, json_encode($export));

        $path = storage_path() . '/app/';

        return response()
            ->download($path . $tempName, $exportName, $headers)
            ->deleteFileAfterSend(true);
    }
}
