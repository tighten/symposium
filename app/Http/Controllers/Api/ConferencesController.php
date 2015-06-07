<?php namespace Symposium\Http\Controllers\Api;

use Carbon\Carbon;
use Conference;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use User;

class ConferencesController extends BaseController
{
    public function index()
    {
        switch (Input::get('filter')) {
            case 'all':
                $conferences = Conference::all();
                break;
            case 'cfp_is_open':
                $conferences = Conference::openCfp()->get();
            case 'future':
                $conferences = Conference::future()->get();
                break;
            case 'unclosed_cfp':
                // Pass through
            default:
                $conferences = Conference::unclosedCfp()->get();
                break;
        }

        $sort = 'closing_next';
        $sortDir = 'asc';

        if (Input::has('sort')) {
            $sort = Input::get('sort');

            if (substr($sort, 0, 1) == '-') {
                $sort = substr($sort, 1);
                $sortDir = 'desc';
            }
        }

        switch ($sort) {
            case 'alpha':
                $conferences->sortBy(function (Conference $model) {
                    return strtolower($model->title);
                });
                break;
            case 'date':
                $conferences->sortBy(function (Conference $model) {
                    return $model->starts_at;
                });
                break;
            case 'closing_next':
                // Pass through
            default:
                // Forces closed CFPs to the end. I feel dirty. Even dirtier with the 500 thing.
                $conferences
                    ->sortBy(function (Conference $model) {
                        if ($model->cfp_ends_at > Carbon::now()) {
                            return $model->cfp_ends_at;
                        } elseif ($model->cfp_ends_at === null) {
                            return Carbon::now()->addYear(500);
                        } else {
                            return $model->cfp_ends_at->addYear(1000);
                        }
                    });
                break;
        }

        if ($sortDir == 'desc') {
            $conferences->reverse();
        }

        return response()->jsonApi([
            'data' => $conferences->values()
        ]);
    }

    public function show($id)
    {
        $conference = Conference::findOrFail($id);

        return response()->jsonApi([
            'data' => $conference
        ]);
    }
}
