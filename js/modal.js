
var modal = (function() {

	var 
	method = {},
	$overlay,
	$modal,
	$content,
	$close;

	// centre the modal within the viewport
	method.center = function() {
		var top, left;

		top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
		left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;
		$modal.css({top:top+$(window).scrollTop(), left:left});

		$modal.css({
			top:top + $(window).scrollTop(), 
			left:left + $(window).scrollLeft() // 1.
		});
	};

	// open the modal
	method.open = function(settings) {
		$content.empty().append(settings.content);

		$modal.css({
			width: settings.width || 'auto',
			height: settings.height || 'auto'
		});

		method.center();
		$(window).bind('resize.modal', method.center); // 2.
		$modal.show();
		$overlay.show();
	};

	// close the modal 
	method.close = function() {
		$modal.hide();
		$overlay.hide();
		$content.empty();
		$(window).unbind('resize.modal');
	};

	// generate the HTML to append
	$overlay = $('<div id="overlay"></div>');
	$modal = $('<div id="modal"></div>');
	$content = $('<div id="content"></div>');
	$close = $('<a id="close" href="#">close</a>');

	$modal.hide();
	$overlay.hide();
	$modal.append($content, $close);

	$(document).ready(function() {
		$('body').append($overlay, $modal);
	});

	$close.on('click', function(e) {
		e.preventDefault();
		method.close();
	});
	// can't get this to work???
	// $overlay.on('click', functione) {
	// 	method.close();
	// });

	return method; // ******************************** very important

}());

// 1.	http://api.jquery.com/scrollTop/ & http://api.jquery.com/scrollLeft/
// 		current vertical/horizontal position of the scroll bar for the 
//		first element in the set of match elements
// 2.	http://docs.jquery.com/Namespaced_Events		
// 		this prevents interference with other resize events happening on the page


