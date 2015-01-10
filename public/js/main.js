$(function() {
	$('[data-toggle=collapse]').on('click', function( e ) {
		var target = $(this).attr('data-target');

		e.preventDefault();

		$(target).toggle();
	});

	$('[data-dismiss=timeout]').each( function() {
		var timeout_len = 2000,
			$dismiss_target = $(this);

		setTimeout(function()
		{
			$dismiss_target.slideToggle()
		}, timeout_len);
	});

	$('input[type=date]').pickadate({
		format: 'yyyy-mm-dd'
	});
});
