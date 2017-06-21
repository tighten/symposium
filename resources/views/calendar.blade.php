@extends('layout')

@section('headerScripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
@endsection

@section('content')
    <div class="container body">
        <div class="row">
            <div id="calendar" class="calendar col-sm-12">
                {{ $calendar->calendar() }}

                <script>
                    jQuery(document).ready(function(){
                        jQuery('#calendar > div').fullCalendar({{ $options }});
                    });
                </script>
            </div>
        </div>
    </div>
@stop
