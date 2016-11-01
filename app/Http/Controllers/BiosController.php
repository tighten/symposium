<?php

namespace App\Http\Controllers;

use App\Bio;
use App\Exceptions\ValidationException;
use App\Services\CreateBioForm;
use Auth;
use Illuminate\Http\Request;
use Input;
use Log;
use Redirect;
use Session;
use Validator;
use View;

class BiosController extends BaseController
{
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
        // @todo: Why is this here? Why aren't we validating like we do everywhere else?
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

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required',
            'body' => 'required',
            'public' => ''
        ]);

        $bio = Auth::user()->bios()->findOrFail($id);

        $bio->nickname = $request->get('nickname');
        $bio->body = $request->get('body');
        $bio->public = $request->get('public') == 'yes';
        $bio->save();

        Session::flash('message', 'Successfully edited bio.');

        return Redirect::to('bios/' . $bio->id);
    }

    public function destroy($id)
    {
        $bio = Auth::user()->bios()->findOrFail($id);

        $bio->delete();

        Session::flash('success-message', 'Bio successfully deleted.');

        return Redirect::to('bios');
    }
}
