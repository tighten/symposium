@component('mail::message')
The following CFPs are now open:

@foreach($conferences as $conference)
- [{{ $conference->title }}]({{ $conference->cfp_url ?: $conference->url }})
@endforeach
@endcomponent
