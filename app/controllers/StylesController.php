<?php

use dflydev\markdown\MarkdownExtraParser;

class StylesController extends BaseController
{
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$style = Style::where('slug', $id)->firstOrFail();

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
