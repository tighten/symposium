<?php namespace Symposium\Http\Controllers;

use Auth;
use Event;
use Hash;
use Input;
use Mail;
use Redirect;
use Session;
use User;
use Validator;

class AccountController extends BaseController
{
    // @todo: Let's get rid of first and last name and just go to a "Name" field. /cc @adamwathan
    protected $account_rules = array(
        'first_name' => 'required_without:last_name',
        'last_name' => 'required_without:first_name',
        'email' => 'email|required|unique:users',
        'enable_profile' => '',
        'profile_slug' => 'unique:users',
    );

    public function __construct()
    {
        $this->beforeFilter('auth', ['except' => ['create', 'store']]);
        $this->beforeFilter('csrf', ['only' => ['update']]);
    }

    public function create()
    {
        return view('account.create');
    }

    public function store()
    {
        $data = Input::all();

        $rules = $this->account_rules;

        // Update rules to add password
        $rules['password'] = 'required';
        $rules['email'] = 'email|required|unique:users,email';

        // Make validator
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            // Save
            $user = new User;
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();

            Event::fire('new-signup', [$user]);
            Auth::loginUsingId($user->id);

            Session::flash('message', 'Successfully created account.');

            return Redirect::to('/account');
        }

        return Redirect::to('sign-up')
            ->withErrors($validator)
            ->withInput();
    }

    public function show()
    {
        $user = User::find(Auth::user()->id);

        return view('account.show')
            ->with('user', $user);
    }

    public function edit()
    {
        $user = User::find(Auth::user()->id);

        return view('account.edit')
            ->with('user', $user);
    }

    public function update()
    {
        $data = Input::all();
        $rules = $this->account_rules;

        // Avoid unique conflict if email not being changed
        if ($data['email'] == Auth::user()->email) {
            $rules['email'] = 'email|required';
        }

        // Avoid unique conflict if profile slug not being changed
        // @todo: There's a cleaner way to do this, isn't there?
        if ($data['profile_slug'] == Auth::user()->profile_slug) {
            $rules['profile_slug'] = '';
        }

        // Make validator
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            // Save
            $user = User::findOrFail(Auth::user()->id);
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');
            if (Input::get('password')) {
                $user->password = Hash::make(Input::get('password'));
            }
            $user->enable_profile = Input::get('enable_profile');
            $user->profile_slug = Input::get('profile_slug');
            $user->save();

            Session::flash('message', 'Successfully edited account.');

            return Redirect::to('account');
        }

        return Redirect::to('account/edit')
            ->withInput()
            ->withErrors($validator);
    }

    public function delete()
    {
        return view('account.confirm-delete');
    }

    public function destroy()
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->delete();

        Auth::logout();

        Session::flash('message', 'Successfully deleted account.');

        return Redirect::to('/');
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
