<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthorsController extends BaseController
{
    public function show($id)
    {
        try {
            $author = User::findOrFail($id);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return redirect('/');
        }

        return view('authors.show')
            ->with('author', $author)
            ->with('talks', $author->talks->sortBy(function ($talk) {
                return $talk->title;
            }));
    }
}
