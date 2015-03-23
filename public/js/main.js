$(function() {
	$('[data-confirm]').on('click', function( e ) {
		if (!confirm("Are you sure you want to delete this record?")) {
			e.preventDefault();
			e.cancelBubble = true;
		}
	});

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

	$('[data-post]').on('click', function(e) {
		e.preventDefault();
		var $that = $(this);

		$.ajax({
			url: "/submissions",
			type: "POST",
			data: $.parseJSON($(this).attr('data-post')),
			success: function() {
				// @todo flash message
				// @todo: Change binding
				$that.text('Submitted').removeClass('btn-primary').addClass('btn-default');
			}
		});
	});

	$('[data-delete]').on('click', function(e) {
		e.preventDefault();
		var $that = $(this);

		$.ajax({
			url: "/submissions",
			type: "DELETE",
			data: $.parseJSON($(this).attr('data-delete')),
			success: function() {
				// @todo flash message
				// @todo: Change binding
				$that.text('Un-submitted').removeClass('btn-default').addClass('btn-primary');
			}
		});
	});
});
