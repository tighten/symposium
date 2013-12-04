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
		// @todo: Limit this to just the needed attributes
		$styles = Style::all();

		return View::make('styles.index')
			->with('styles', $styles->sortBy(function($style)
				{
					return $style->title;
				})
			);
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
