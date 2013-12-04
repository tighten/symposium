$(function() {
	$('[data-toggle=collapse]').on('click', function() {
		var target = $(this).attr('data-target');

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
	$('[data-tab-toggle]').on('click', function() {
		var target = $(this).attr('data-tab-toggle');

		$('.tab').removeClass('active');
		$(target).addClass('active');

		$(this).closest('ul').find('li').removeClass('active');
		$(this).closest('li').addClass('active');
	});
});
