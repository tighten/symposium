$(function() {
	$('[data-toggle=collapse]').on('click', function( e ) {
		var target = $(this).attr('data-target');

		e.preventDefault();

		$(target).toggle();
	});

	$('[data-dismiss=timeout]').each( function( e ) {
		var timeout_len = 2000,
			$dismiss_target = $(this);
		
		e.preventDefault();

		setTimeout(function()
		{
			$dismiss_target.slideToggle()
		}, timeout_len);
	});
	
	$('[data-tab-toggle]').on('click', function( e ) {
		var target = $(this).attr('data-tab-toggle');

		e.preventDefault();

		$('.tab').removeClass('active');
		$(target).addClass('active');

		$(this).closest('ul').find('li').removeClass('active');
		$(this).closest('li').addClass('active');
	});
});
