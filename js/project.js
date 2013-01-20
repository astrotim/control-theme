jQuery(document).ready(function($) {

	// initialise conditionizr
	$('head').conditionizr();

	// placeholder text polyfill
	if(!Modernizr.input.placeholder){

		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			})
		});
	}


	// bootstrap dropdown
	// add bootstrap class to items with default WP class
	$('#nav .dropdown .sub-menu').addClass('dropdown-menu');

	// run bootstrap dropdown & append the arrow element
	$('#nav .dropdown > a').append('<b class="caret"></b>').dropdown();

});








