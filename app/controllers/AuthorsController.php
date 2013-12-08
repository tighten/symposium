<?php

class AuthorsController extends BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	// public function index()
	// {
	// 	return View::make('authors.index');
	// }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	// public function create()
	// {
	// 	return View::make('authors.create');
	// }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	// public function store()
	// {
	// 	//
	// }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$author = User::findOrFail($id);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
			Log::error($e);
			return Redirect::to('/');
		}

		return View::make('authors.show')
			->with('author', $author)
			->with('styles', $author->styles->sortBy(function($style)
				{
					return $style->title;
				})
			);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function edit($id)
	// {
	// 	return View::make('authors.edit');
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function update($id)
	// {
	// 	//
	// }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function destroy($id)
	// {
	// 	//
	// }

}
