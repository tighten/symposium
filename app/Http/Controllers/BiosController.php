<?php

namespace App\Http\Controllers;

use App\Repository\BiosRepository;
use App\Http\Requests\SaveBioRequest;

class BiosController extends Controller
{
    private $bioRepository;

    public function __construct(BiosRepository $bioRepository)
    {
        $this->bioRepository = $bioRepository;
    }

    public function index()
    {
        return view('bios.index', [
            'bios' => $this->bioRepository->getUserBio()
        ]);
    }

    public function create()
    {
        return view('bios.create', [
            'bio' => $this->bioRepository->getModel()
        ]);
    }

    public function store(SaveBioRequest $request)
    {
        $bio = $this->bioRepository->createUserBio($request->validated());
        return redirect()->route('bios.show', $bio->id)
            ->with('success-message', 'Successfully created new bio.');
    }

    public function show($id)
    {
        return view('bios.show', [
            'bio' => $this->bioRepository->findUserBio($id),
        ]);
    }

    public function edit($id)
    {
        return view('bios.edit', [
            'bio' => $this->bioRepository->findUserBio($id),
        ]);
    }

    public function update(SaveBioRequest $request, $id)
    {
        $this->bioRepository->updateUserBioById($request->validated(), $id);
        return redirect()->route('bios.show', $id)
            ->with('success-message', 'Successfully edited bio.');
    }

    public function destroy($id)
    {
        $this->bioRepository->deleteUserBioById($id);
        return redirect()->route('bios.index')
            ->with('success-message', 'Bio successfully deleted.');
    }
}