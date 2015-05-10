<?php namespace Symposium\Http\Controllers;

use Symposium\Services\CreateBioForm;
use Auth;
use Bio;
use Illuminate\Support\Collection;
use Input;
use Log;
use Redirect;
use Session;
use Validator;
use View;

use Symposium\Exceptions\ValidationException;

class BiosController extends BaseController
{
    // @todo: Why is this here but only used for update? Why are they not using the same pattern?
    protected $validation = [
    ];

    public function index()
    {
        $bios = Bio::where('user_id', Auth::user()->id)
            ->orderBy('nickname')
            ->get();

        return View::make('bios.index')
            ->with('bios', $bios);
    }

    public function create()
    {
        return View::make('bios.create')
            ->with('bio', new Bio());
    }

    public function store()
    {
        $form = CreateBioForm::fillOut(Input::all(), Auth::user());

        try {
            $bio = $form->complete();
        } catch (ValidationException $e) {
            return Redirect::to('bios/create')
                ->withErrors($e->errors())
                ->withInput();
        }

        Session::flash('message', 'Successfully created new bio.');

        return Redirect::to('/bios/' . $bio->id);
    }

    public function show($id)
    {
        try {
            $bio = Bio::where('id', $id)->firstOrFail();
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        if ($bio->user_id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that bio.');
            Log::error('User ' . Auth::user()->id . ' tried to view a bio they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('bios.show')
            ->with('bio', $bio);
    }

    public function edit($id)
    {
        try {
            $bio = Bio::where('id', $id)->firstOrFail();
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        if ($bio->user_id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that bio.');
            Log::error('User ' . Auth::user()->id . ' tried to edit a bio they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('bios.edit')
            ->with('bio', $bio);
    }

    public function update($id)
    {
        $data = Input::all();

        // Make validator
        $validator = Validator::make($data, $this->validation);

        if ($validator->passes()) {
            // Pull
            $bio = Bio::where('id', $id)->firstOrFail();

            // Validate ownership
            if ($bio->user_id != Auth::user()->id) {
                Session::flash('error-message', 'Sorry, but you don\'t own that bio.');
                Log::error('User ' . Auth::user()->id . ' tried to edit a bio they don\'t own.');
                return Redirect::to('/');
            }

            // Save
            $bio->body = Input::get('body');
            $bio->user_id = Auth::user()->id;
            $bio->save();

            Session::flash('message', 'Successfully edited bio.');

            return Redirect::to('bios/' . $bio->id);
        }

        return Redirect::to('bios/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput();
    }

    public function destroy($id)
    {
        $bio = Bio::where('id', $id)->firstOrFail();

        // Validate ownership
        if ($bio->user_id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that bio.');
            Log::error('User ' . Auth::user()->id . ' tried to delete a bio they don\'t own.');
            return Redirect::to('/');
        }

        Session::flash('success-message', 'Bio successfully deleted.');
        $bio->delete();

        return Redirect::to('bios');
    }
}
