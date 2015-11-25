@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <a href="{{ route('bios.create') }}" class="create-button">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <h2 class="page-title">All Bios</h2>

                <ul class="list-bios">
                    @forelse ($bios as $bio)
                        <li>
                            @include ('partials.bio-in-list', ['bio' => $bio])
                        </li>
                    @empty
                        <li>No bios yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
@stop
