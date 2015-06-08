@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/bios/">Bios</a></li>
        </ol>

        <a href="/bios/create" class="create-button">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

        <h2>All Bios</h2>

        <ul class="list-bios">
            @forelse ($bios as $bio)
                <li>
                    <h3><a href="/bios/{{ $bio->id }}">{{ $bio->nickname }}</a></h3>
                    <p>{{ $bio->preview }}</p>

                    <div class="modal fade bio-modal" id="modal-{{ $bio->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Copy bio</h4>
                          </div>
                          <div class="modal-body">
                            <textarea class="select-me" style="width: 100%; height: 10em;">{{ $bio->body }}</textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <p>
                    <a href="/bios/{{ $bio->id }}/delete" data-confirm="confirm"><button type="button" class="btn btn-xs btn-danger">Delete</button></a>
                    <a href="/bios/{{ $bio->id }}/edit"><button type="button" class="btn btn-xs btn-default">Edit</button></a>
                    <a href="#" data-toggle="modal" data-target="#modal-{{ $bio->id }}"><button type="button" class="btn btn-xs btn-default">Copy</button></a>
                    </p>
                </li>
            @empty
                <li>No bios yet.</li>
            @endforelse
        </ul>
    </div>
@stop
