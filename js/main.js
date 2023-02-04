$('li.profile-btn').click( function () {
	$('.profile-btn').toggleClass('active');
});

$('.friend-button-view').click( function () {
	var id = $(this).attr('id');
	var element = $('.form' + id);
	element.click();
});

$('.edit-photo').click( function() {
	$('.edit-photo-block').addClass('active animate__zoomInUp');
	$('.black-window').addClass('active');
	$('.black-window').animate({
		opacity: 0.6
	}, 1000);
	$("body").css("overflow","hidden"); 
});

$('.close-upload-photo').click( function() {
	$('.edit-photo-block').removeClass('active animate__zoomInUp');
	$('.black-window').removeClass('active');
	$('.black-window').css({
		opacity: 0
	});
	$("body").css("overflow","auto"); 
});

$('.view-friend-list-button').click( function() {
	$('.view-friend-list').click();
	return false;
});

$('.view-friend-list-button-left').click( function() {
	$('.view-friend-list-left').click();
});

$('.like-button').click( function () {
	var element = $(this).attr('id');
	$('input#' + element).click();
	$(this).attr('src', "../img/like_active.svg");
});

$('.delete-news-wall').click( function () {
	var element = $(this).attr('id');
	$('input#' + element).click();
});

$('.status-user').click( function() {
	$('.status-user-edit').addClass('active animate__zoomInUp');
	$('.black-window').addClass('active');
	$('.black-window').animate({
		opacity: 0.6
	}, 1000);
	$("body").css("overflow","hidden"); 
});

$('.message-user').click( function () {
	var element = $(this).attr('id');
	$('input#' + element).click();
});

$('.message-user').click( function () {
	var element = $(this).attr('id');
	$('.friend .item input#message-' + element).click();
});

$('.message .block .grid .item').click( function() {
	$(this).toggleClass('selected');
});

