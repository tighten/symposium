@extends('layout')

@section('content')
	
<div class="container">

<h1>How do I use these styles?</h1>
<p>By Brett Terpstra, from <a href="https://github.com/ttscoff/MarkedCustomStyles">MarkedCustomStyles</a> github.</p>

<h2>Using a Style</h2>

<p>Just save the CSS file to your disk. You can open any Style in the list and then hit the "Raw" button to get a file ready for "Save to...". I suggest saving to ~/Library/Application Support/Marked/Custom CSS, as in the near future Marked will read from that folder automatically.</p>

<p>Then, open up the Style Preferences in Marked and click the "+" button under the Custom Styles list. Locate the file and select it. Now it will appear in your Styles dropdown selection and you can optionally make it the default window style.</p>

<p>Custom Styles are added to the keyboard menu under Command-Opt-#, where # is 1-9 in the order they're added.</p>

<h2>Creating a Style</h2>

<p>I've been creating my styles with Compass and Sass, with a document containing a full range of markup elements for testing. I just turn on compass watch and point Marked's Style to the output CSS file. Turn on "Track CSS Changes" under the Style list in Marked, and every time Compass compiles, Marked will update without refreshing the page (LiveReload-style injection). You can use whatever you like, including directly editing plain CSS.</p>

<p>The document markup hasn't changed between v1 and v2 of Marked, so the original style guide still applies. There are just a few things to worry about for full compatibility. Inverted styles, poetry mode and print settings. However, submissions that lack any of these are still accepted, as people can add their own if they need to.</p>

<p>The one thing your Style does need (aside from looking great in Marked), is the header.css information, customized to your Style. Just stick it at the top.</p>

<p>I prefer to Base 64 encode any custom fonts in order to make the Stylesheet a single-file download with no online requirements. If you can make it work other ways, I'm open to folder downloads, etc. Eventually I plan to create a bundle format for them.</p>

<p>Thanks, and I hope you'll consider sharing the custom styles you create, even if they're revisions and evolutions of existing styles!</p>
</div>
@stop
