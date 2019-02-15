@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <a href="{{ route('bios.create') }}" class="create-button">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <h2 class="page-title">All Bios</h2>

                <ul class="list-bios">
                  @each('partials.bio-in-list', $bios, 'bio', 'partials.bio-in-list-empty')
                </ul>
            </div>
        </div>

    </div>
@stop
