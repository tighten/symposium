@extends('app')

@section('content')
    <div id="calendar" class="calendar mt-8">
        {!! $calendar->calendar() !!}
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script>
        jQuery(document).ready(function(){
            jQuery('#calendar > div').fullCalendar({!! $options !!});
        });
    </script>
@endpush
