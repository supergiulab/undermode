// Plugin Main JS File
// @package plugin
( function( $ ) {
	"use strict";
	// The "Upload" button
	$('.upload_image_button').each(function(){
		$(this).click(function() {
			var send_attachment_bkp = wp.media.editor.send.attachment;
			var button = $(this);
			wp.media.editor.send.attachment = function(props, attachment) {
				$(button).parent().prev().attr('src', attachment.url);
				console.log(attachment);
				$(button).prev().val(attachment.id);
				wp.media.editor.send.attachment = send_attachment_bkp;
			}
			wp.media.editor.open(button);
			return false;
		});
	});

	// The "Remove" button (remove the value from input type='hidden')
	$('.remove_image_button').click(function() {
		var answer = confirm('Are you sure?');
		if (answer == true) {
			var $w = $(this).parent().prev().attr('width'),
				$h = $(this).parent().prev().attr('height'),
				$p_url = 'http://via.placeholder.com/' + $w + 'x' + $h;

			$(this).parent().prev().attr('src', $p_url);
			$(this).prev().prev().val('');
		}
		return false;
	});
} )( jQuery );