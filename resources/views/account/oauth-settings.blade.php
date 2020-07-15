@extends('layout', ['title' => 'OAuth settings'])

@section('content')

<passport-clients></passport-clients>
<passport-authorized-clients class="mt-4"></passport-authorized-clients>
<passport-personal-access-tokens class="mt-4"></passport-personal-access-tokens>

@endsection
