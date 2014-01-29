<?php

// use dflydev\markdown\MarkdownExtraParser;

class StylesController extends BaseController
{
	protected $account_rules = array(
		'title' => 'required',
		'description' => 'required',
		'source' => 'required',
		'format' => 'required'
	);

	protected $sorting_styles = array(
			'date' => '',
			'alpha' => '',
			'popularity' => ''
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
		$bold_style = 'style="font-weight: bold;"';

		$sorting_style = $this->sorting_styles;

		switch (Input::get('sort')) {
			case 'date':
				$sorting_style['date'] = $bold_style;
				$styles = Style::orderBy('created_at', 'DESC')->get();
				break;
			case 'popularity':
				$sorting_style['popularity'] = $bold_style;
				$styles = Style::orderBy('visits', 'DESC')->get();
				break;
			case 'alpha':
				// Pass through
			default:
				$sorting_style['alpha'] = $bold_style;
				$styles = Style::orderBy('title', 'ASC')->get();
				break;
		}

		// Sum visits
		$total_visits = 0;
		foreach ($styles as $style) {
			$total_visits += $style->visits;
		}

		return View::make('styles.index')
			->with('styles', $styles)
			->with('sorting_style', $sorting_style)
			->with('total_visits', $total_visits);
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

		$style->increment('visits');

        return View::make('styles.show')
        	->with('style', $style)
        	->with('author', $style->author);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  str  $slug
	 * @return Response
	 */
	public function edit($slug)
	{
		try {
			$style = Style::where('slug', $slug)->firstOrFail();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
			Log::error($e);
			return Redirect::to('/');
		}

		if ($style->author->id != Auth::user()->id) {
			Session::flash('error-message', 'Sorry, but you don\'t own that style.');
			Log::error('User ' . Auth::user()->id . ' tried to edit a style they don\'t own.');
			return Redirect::to('/');
		}

		return View::make('styles.edit')
			->with('style', $style);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  str  $slug
	 * @return Response
	 */
	public function update($slug)
	{
		$data = Input::all();

		$rules = $this->account_rules;

		// Make validator
		$validator = Validator::make($data, $rules);

		if ($validator->passes()) {
			// Pull
			$style = Style::where('slug', $slug)->firstOrFail();

			// Validate ownership
			if ($style->author->id != Auth::user()->id) {
				Session::flash('error-message', 'Sorry, but you don\'t own that style.');
				Log::error('User ' . Auth::user()->id . ' tried to edit a style they don\'t own.');
				return Redirect::to('/');
			}

			// Save
			$style->title = Input::get('title');
			$style->slug = Str::slug(Input::get('title'));
			$style->description = Input::get('description');
			$style->source = Input::get('source');
			// $style->format = Input::get('format');
			$style->format = 'css'; // For now...
			$style->author_id = Auth::user()->id;
			// Add author
			$style->save();

			Session::flash('message', 'Successfully edited style.');

			return Redirect::to('/styles/' . $style->slug);
		}

		return Redirect::to('styles/' . $slug . '/edit')
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
	 * @param  string $slug Style slug
	 */
	public function preview($slug)
	{
		try {
			$style = Style::where('slug', $slug)->firstOrFail();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return '';
		}

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
