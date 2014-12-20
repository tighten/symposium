<?php

class TalksController extends BaseController
{
	protected $account_rules = array(
		'title' => 'required',
		'description' => 'required',
		'body' => 'required',
	);

	protected $sorting_talks = array(
			'date' => '',
			'alpha' => '',
		);

	public function __construct()
	{
		$this->beforeFilter(
			'auth',
			array(
				'only' => array(
					'create',
					'store',
					'edit',
					'update',
					'destroy'
				)
			)
		);
	}

	/**
	 * Display all of the current user's talks
	 *
	 * @return Response
	 */
	public function index()
	{
		$bold_style = 'style="font-weight: bold;"';

		$sorting_talk = $this->sorting_talks;

		switch (Input::get('sort')) {
			case 'date':
				$sorting_talk['date'] = $bold_style;
				$talks = Talk::orderBy('created_at', 'DESC')->currentUserOnly()->get();
				break;
			case 'alpha':
				// Pass through
			default:
				$sorting_talk['alpha'] = $bold_style;
				$talks = Talk::orderBy('title', 'ASC')->currentUserOnly()->get();
				break;
		}

		return View::make('talks.index')
			->with('talks', $talks)
			->with('sorting_talk', $sorting_talk);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('talks.create');
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

		// Make validator
		$validator = Validator::make($data, $rules);

		if ($validator->passes()) {
			// Save
			$talk = new Talk;
			$talk->title = Input::get('title');
			$talk->description = Input::get('description');
			$talk->body = Input::get('body');
			$talk->author_id = Auth::user()->id;
			// Add author
			$talk->save();

			Session::flash('message', 'Successfully created new talk.');

			return Redirect::to('/talks/' . $talk->id);
		}

		return Redirect::to('talks/create')
			->withErrors($validator)
			->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$talk = Talk::where('id', $id)->firstOrFail();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
			Log::error($e);
			return Redirect::to('/');
		}

        return View::make('talks.show')
        	->with('talk', $talk)
        	->with('author', $talk->author);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  str  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$talk = Talk::where('id', $id)->firstOrFail();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
			Log::error($e);
			return Redirect::to('/');
		}

		if ($talk->author->id != Auth::user()->id) {
			Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
			Log::error('User ' . Auth::user()->id . ' tried to edit a talk they don\'t own.');
			return Redirect::to('/');
		}

		return View::make('talks.edit')
			->with('talk', $talk);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  str  $id
	 * @return Response
	 */
	public function update($id)
	{
		$data = Input::all();

		$rules = $this->account_rules;

		// Make validator
		$validator = Validator::make($data, $rules);

		if ($validator->passes()) {
			// Pull
			$talk = Talk::where('id', $id)->firstOrFail();

			// Validate ownership
			if ($talk->author->id != Auth::user()->id) {
				Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
				Log::error('User ' . Auth::user()->id . ' tried to edit a talk they don\'t own.');
				return Redirect::to('/');
			}

			// Save
			$talk->title = Input::get('title');
			$talk->description = Input::get('description');
			$talk->body = Input::get('body');
			$talk->author_id = Auth::user()->id;
			// Add author
			$talk->save();

			Session::flash('message', 'Successfully edited talk.');

			return Redirect::to('talks/' . $talk->id);
		}

		return Redirect::to('talks/' . $id . '/edit')
			->withErrors($validator)
			->withInput();
	}

	/**
	 * Show the confirmation for deleting the specified resource
	 * 
	 * @param  int  $id
	 * @return Resource
	 */
	public function delete($id)
	{
		dd('t');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$talk = Talk::where('id', $id)->firstOrFail();

		// Validate ownership
		if ($talk->author->id != Auth::user()->id) {
			Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
			Log::error('User ' . Auth::user()->id . ' tried to delete a talk they don\'t own.');
			return Redirect::to('/');
		}

		$talk->delete();

		return Redirect::to('talks');
	}
}
