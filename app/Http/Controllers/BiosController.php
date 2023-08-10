<?php

namespace App\Http\Controllers;

use App\Models\Bio;
use App\Http\Requests\SaveBioRequest;
use App\Http\Requests\UpdateBioRequest;
use Illuminate\Support\Facades\Auth;

class BiosController extends Controller
{
    public function index()
    {
        $bios = auth()->user()->bios;

        return view('bios.index', [
            'bios' => $bios,
        ]);
    }

    public function create()
    {
        return view('bios.create', [
            'bio' => new Bio(),
        ]);
    }

    public function store(SaveBioRequest $request)
    {
        $validatedData = $request->validated();

        $bio = Bio::create(array_merge($validatedData, [
                'user_id' => Auth::id(),
            ])
        );

        return redirect('/bios/' . $bio->id)->with('success-message', 'Successfully created new bio.');
    }

    public function show($id)
    {
        $bio = auth()->user()->bios()->findOrFail($id);

        return view('bios.show', [
            'bio' => $bio,
        ]);
    }

    public function edit($id)
    {
        $bio = auth()->user()->bios()->findOrFail($id);

        return view('bios.edit', [
            'bio' => $bio,
        ]);
    }

    public function update(UpdateBioRequest $request, $id)
    {
        $validatedData = $request->validated();

        $bio = auth()->user()->bios()->findOrFail($id);

        $bio->nickname = $validatedData['nickname'];
        $bio->body = $validatedData['body'];
        $bio->public = $validatedData['public'];
        $bio->save();

        return redirect('bios/' . $bio->id)->with('success-message', 'Successfully edited bio.');
    }

    public function destroy($id)
    {
        $bio = auth()->user()->bios()->findOrFail($id);

        $bio->delete();

        return redirect('bios')->with('success-message', 'Bio successfully deleted.');
    }
}
