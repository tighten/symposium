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
    protected $account_rules = array(
        'first_name' => 'required_without:last_name',
        'last_name' => 'required_without:first_name',
        'email' => 'email|required|unique:users',
    );

    public function __construct()
    {
        $this->beforeFilter('auth', array('except' => array('create', 'store')));
        $this->beforeFilter('csrf', array('only' => array('update')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
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

    /**
     * Display account
     *
     * @return Response
     */
    public function show()
    {
        $user = User::find(Auth::user()->id);

        return view('account.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing account
     *
     * @return Response
     */
    public function edit()
    {
        $user = User::find(Auth::user()->id);

        return view('account.edit')
            ->with('user', $user);
    }

    /**
     * Update account
     *
     * @return Response
     */
    public function update()
    {
        $data = Input::all();
        $rules = $this->account_rules;

        // Avoid unique conflict if email not being changed
        if ($data['email'] == Auth::user()->email) {
            $rules['email'] = 'email|required';
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
            $user->save();

            Session::flash('message', 'Successfully edited account.');

            return Redirect::to('account');
        }

        return Redirect::to('account/edit')
            ->withInput()
            ->withErrors($validator);
    }

    /**
     * Show the confirmation for deleting account
     *
     * @return Response
     */
    public function delete()
    {
        return view('account.confirm-delete');
    }

    /**
     * Remove account
     *
     * @return Response
     */
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
        $user->load('talks.versions.revisions');

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
