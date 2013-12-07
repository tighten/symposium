<?php

use dflydev\markdown\MarkdownExtraParser;

class StylesController extends BaseController
{
	protected $account_rules = array(
		'title' => 'required|alpha_dash',
		'description' => 'required',
		'source' => 'required',
		'format' => 'required'
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
	 * Display all styles
	 *
	 * @return Response
	 */
	public function index()
	{
		$sorting_date_style = $sorting_alpha_style = '';

		// @todo: Limit this to just the needed attributes
		if (Input::get('sort') && Input::get('sort') == 'date') {
			$styles = Style::orderBy('created_at', 'DESC')->get();
			$sorting_date_style = 'style="font-weight: bold;"';
		} else {
			$styles = Style::orderBy('title', 'ASC')->get();
			$sorting_alpha_style = 'style="font-weight: bold;"';
		}

		return View::make('styles.index')
			->with('styles', $styles)
			->with('sorting_date_style', $sorting_date_style)
			->with('sorting_alpha_style', $sorting_alpha_style);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('styles.create');
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
			$style = new Style;
			$style->title = Input::get('title');
			$style->slug = Str::slug(Input::get('title'));
			$style->description = Input::get('description');
			$style->source = Input::get('source');
			// $style->format = Input::get('format');
			$style->format = 'css'; // For now...
			$style->author_id = Auth::user()->id;
			// Add author
			$style->save();

			Session::flash('message', 'Successfully created new style.');

			return Redirect::to('/styles/' . $style->slug);
		}

		return Redirect::to('styles/create')
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
			$style = Style::where('slug', $id)->firstOrFail();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
			Log::error($e);
			return Redirect::to('/');
		}

        return View::make('styles.show')
        	->with('style', $style)
        	->with('author', $style->author);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('styles.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Show the confirmation for deleting the specified resource
	 * 
	 * @param  int  $id
	 * @return Resource
	 */
	public function delete($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Preview style
	 * 
	 * @param  int $id Style #
	 */
	public function preview($id)
	{
		$style = Style::find($id);

		// Dflydev/markdown couldn't handle some of the more complex md code
		// $preview_content = File::get('../app/views/styles/preview.md');

		// $markdownParser = new MarkdownExtraParser();

		// $preview = $markdownParser->transformMarkdown($preview_content);
		
		$preview = File::get('../app/views/styles/preview.html');

		return View::make('styles.preview')
			->with('style', $style)
			->with('preview', $preview);
	}
}
