/*
 

 *

 *

 * -------




 */

$(document).ready(function()
{
	/* CSRF Protection */
	var token = $('meta[name="csrf-token"]').attr('content');
	if (token) {
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': token}
		});
	}

	$('.showphone').click(function(){
		showPhone();
	});
});

/**
 * Show the Contact's phone
 * @returns {boolean}
 */
function showPhone()
{
	return false; /* Desactivated */
	
	if ($('#postId').val()==0) {
		return false;
	}

	$.ajax({
		method: 'POST',
		url: siteUrl + '/ajax/post/phone',
		data: {
			'postId': $('#postId').val(),
			'_token': $('input[name=_token]').val()
		}
	}).done(function(data) {
		if (typeof data.phone == "undefined") {
			return false;
		}
		$('.showphone').html('<i class="icon-phone-1"></i> ' + data.phone);
		$('#postId').val(0);
	});
}