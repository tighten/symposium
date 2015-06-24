<?php namespace Symposium\Http\Controllers\Api;

use Carbon\Carbon;
use Conference as EloquentConference;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Symposium\ApiResources\Conference;
use User;

class ConferencesController extends BaseController
{
    public function index()
    {
        switch (Input::get('filter')) {
            case 'all':
                $conferences = EloquentConference::all();
                break;
            case 'future':
                $conferences = EloquentConference::future()->get();
                break;
            case 'open_cfp':
                $conferences = EloquentConference::openCfp()->get();
                break;
            case 'unclosed_cfp':
                // Pass through
            default:
                $conferences = EloquentConference::unclosedCfp()->get();
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
                $conferences->sortBy(function (EloquentConference $model) {
                    return strtolower($model->title);
                });
                break;
            case 'date':
                $conferences->sortBy(function (EloquentConference $model) {
                    return $model->starts_at;
                });
                break;
            case 'closing_next':
                // Pass through
            default:
                // Forces closed CFPs to the end. I feel dirty. Even dirtier with the 500 thing.
                $conferences
                    ->sortBy(function (EloquentConference $model) {
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
        $conference = EloquentConference::findOrFail($id);
        $conference = new Conference($conference);

        return response()->jsonApi([
            'data' => $conference->toArray()
        ]);
    }
}
