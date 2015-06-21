<?php namespace Symposium\Http\Controllers;

use Auth;
use Bio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Input;
use Log;
use Redirect;
use Session;
use Symposium\Exceptions\ValidationException;
use Symposium\Services\CreateBioForm;
use Validator;
use View;

class BiosController extends BaseController
{
    // @todo: Why is this here but only used for update? Why are they not using the same pattern?
    protected $validation = [
    ];

    public function index()
    {
        $bios = Auth::user()->bios;

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
        $bio = Auth::user()->bios()->findOrFail($id);

        return View::make('bios.show')
            ->with('bio', $bio);
    }

    public function edit($id)
    {
        $bio = Auth::user()->bios()->findOrFail($id);

        return View::make('bios.edit')
            ->with('bio', $bio);
    }

    public function update($id)
    {
        $validator = Validator::make(Input::all(), $this->validation);

        if ($validator->passes()) {
            $bio = Auth::user()->bios()->findOrFail($id);

            $bio->nickname = Input::get('nickname');
            $bio->body = Input::get('body');
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
        $bio = Auth::user()->bios()->findOrFail($id);

        $bio->delete();

        Session::flash('success-message', 'Bio successfully deleted.');

        return Redirect::to('bios');
    }
}
