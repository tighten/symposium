<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Conference;
use App\Http\Controllers\Controller;
use App\Models\Conference as EloquentConference;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConferencesController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->input('filter')) {
            case 'all':
                $conferences = EloquentConference::all();
                break;
            case 'future':
                $conferences = EloquentConference::future()->get();
                break;
            case 'open_cfp':
                $conferences = EloquentConference::whereCfpIsOpen()->get();
                break;
            case 'unclosed_cfp':
                // Pass through
            default:
                $conferences = EloquentConference::cfpIsOpen()->get();
                break;
        }

        $sort = 'closing_next';
        $sortDir = 'asc';

        if ($request->filled('sort')) {
            $sort = $request->input('sort');

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
            'data' => $conferences->map(function ($conference) {
                return (new Conference($conference))->toArray();
            })->values(),
        ]);
    }

    public function show($id)
    {
        $conference = new Conference(EloquentConference::findOrFail($id));

        return response()->jsonApi([
            'data' => $conference->toArray(),
        ]);
    }
}
