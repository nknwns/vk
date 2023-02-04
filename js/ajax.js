$(document).ready(function () {
	/* Like function */
	$('img.like-button').click( function () {
		$.post( "account.php", {
			like_post: true,
			item_id: $(this).attr('id')
		});
		if ($(this).hasClass('liked')) {
			$(this).attr('src', "../img/like.svg");
			$(this).removeClass('liked');
			var parent = $(this).parent('span');
			var child = parent.children('span');
			var old = parseInt(child.html(), 10);
			child.html(old - 1);
		} else {
			$(this).attr('src', "../img/like_active.svg");
			$(this).addClass('liked');
			var parent = $(this).parent('span');
			var child = parent.children('span');
			var old = parseInt(child.html(), 10);
			child.html(old + 1);
		}
	});
	/* Submit message */
	$('input[name="message-button"]').click( function () {
		$.post( "submit_message.php", {
			id_user : $('input[name="message-input"]').attr('id'),
			text : $('input[name="message-input"]').val(),
			type : '0',
			message_submit : true
		}, function (data) {
			$('input[name="message-input"]').val('');
			$('.message .grid .temp-object').html($('.message .grid .temp-object').html() + data);
		});
	});
});