<?php

class AccountController extends BaseController
{
	protected $account_rules = array(
		'first_name' => 'required_without:last_name',
		'last_name' => 'required_without:first_name',
		'email' => 'email|required',
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
		return View::make('account.create');
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$user = User::find(Auth::user()->id);

		return View::make('account.show')
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

		return View::make('account.edit')
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

		// Make validator
		$validator = Validator::make($data, $this->account_rules);

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
		return View::make('account.confirm-delete');
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

}
