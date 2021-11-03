@extends('app')

@section('content')
    <conference-calendar
        id="calendar"
        :events="{{ $events }}"
    />
@endsection
