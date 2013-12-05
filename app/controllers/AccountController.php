<?php

class AccountController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf', array('only' => array('update')));
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

		// Set validation rules
		$rules = array(
			'first_name' => 'required_without:last_name',
			'last_name' => 'required_without:first_name',
			'email' => 'email|required',
			'twitter' => 'alpha_dash',
			'url' => 'url'
		);

		// Make validator
		$validator = Validator::make($data, $rules);

		if ($validator->passes()) {
			// Save
			$user = User::findOrFail(Auth::user()->id);
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
			$user->twitter = Input::get('twitter');
			$user->url = Input::get('url');
			$user->save();

			Session::flash('message', 'Successfully edited account.');

			return Redirect::to('account');
		}

		return Redirect::to('account/edit')->withErrors($validator);
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
