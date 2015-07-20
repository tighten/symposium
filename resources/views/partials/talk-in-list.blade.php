<h3><a href="/talks/{{ $talk->id }}">{{ $talk->current()->title }}</a></h3>
<p class="talk-meta"><i>{{ $talk->created_at->toFormattedDateString()  }}</i> | {{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}</p>
