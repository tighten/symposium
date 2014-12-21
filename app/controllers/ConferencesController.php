<?php

class ConferencesController extends BaseController
{
    protected $account_rules = [
        'title' => 'required',
        'description' => 'required',
        'url' => 'required',
    ];

    protected $sorting_conferences = [
        'date' => '',
        'alpha' => '',
    ];

    public function __construct()
    {
        $this->beforeFilter(
            'auth',
            [
                'only' => [
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy'
                ]
            ]
        );
    }

    /**
     * Display all conferences
     *
     * @return Response
     */
    public function index()
    {
        $bold_style = 'style="font-weight: bold;"';

        $sorting_conference = $this->sorting_conferences;

        switch (Input::get('sort')) {
            case 'date':
                $sorting_conference['date'] = $bold_style;
                $conferences = Conference::orderBy('created_at', 'DESC')->get();
                break;
            case 'alpha':
                // Pass through
            default:
                $sorting_conference['alpha'] = $bold_style;
                $conferences = Conference::orderBy('title', 'ASC')->get();
                break;
        }

        return View::make('conferences.index')
            ->with('conferences', $conferences)
            ->with('sorting_conference', $sorting_conference);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('conferences.create');
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
            $conference = new Conference;
            $conference->title = Input::get('title');
            $conference->description = Input::get('description');
            $conference->url = Input::get('url');
            $conference->starts_at = Input::get('starts_at');
            $conference->ends_at= Input::get('ends_at');
            $conference->cfp_starts_at = Input::get('cfp_starts_at');
            $conference->cfp_ends_at = Input::get('cfp_ends_at');
            $conference->author_id = Auth::user()->id;

            $conference->save();

            Session::flash('message', 'Successfully created new conference.');

            return Redirect::to('/conferences/' . $conference->id);
        }

        return Redirect::to('conferences/create')
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $conference = Conference::where('id', $id)->firstOrFail();
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        return View::make('conferences.show')
            ->with('conference', $conference)
            ->with('author', $conference->author);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  str $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $conference = Conference::where('id', $id)->firstOrFail();
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        if ($conference->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that conference.');
            Log::error('User ' . Auth::user()->id . ' tried to edit a conference they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('conferences.edit')
            ->with('conference', $conference);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  str $id
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
            $conference = Conference::where('id', $id)->firstOrFail();

            // Validate ownership
            if ($conference->author->id != Auth::user()->id) {
                Session::flash('error-message', 'Sorry, but you don\'t own that conference.');
                Log::error('User ' . Auth::user()->id . ' tried to edit a conference they don\'t own.');
                return Redirect::to('/');
            }

            // Save
            $conference->title = Input::get('title');
            $conference->description = Input::get('description');
            $conference->url = Input::get('url');
            $conference->starts_at = Input::get('starts_at');
            $conference->ends_at= Input::get('ends_at');
            $conference->cfp_starts_at = Input::get('cfp_starts_at');
            $conference->cfp_ends_at = Input::get('cfp_ends_at');
            $conference->author_id = Auth::user()->id;
            // Add author
            $conference->save();

            Session::flash('message', 'Successfully edited conference.');

            return Redirect::to('conferences/' . $conference->id);
        }

        return Redirect::to('conferences/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Show the confirmation for deleting the specified resource
     *
     * @param  int $id
     * @return Resource
     */
    public function delete($id)
    {
        dd('t');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $conference = Conference::where('id', $id)->firstOrFail();

        // Validate ownership
        if ($conference->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that conference.');
            Log::error('User ' . Auth::user()->id . ' tried to delete a conference they don\'t own.');
            return Redirect::to('/');
        }

        $conference->delete();

        return Redirect::to('conferences');
    }
}
