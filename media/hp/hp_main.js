jQuery.noConflict();

function imwb_move_sidebar() {}

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

jQuery(function($){
	$('.user-toolbar button').click(function(){
		
		var task = $(this).attr('rel');
		var form = $('form[name="userForm"]');
		
		// set task
		$('input[type="hidden"][name="task"]').val(task);
		
		var tmp = task.split('.');
		
		if (tmp[1] == 'cancel' || tmp[1] == 'add')
		{
			// remove validate
			$(form).validate({ignore: ".ignore"}).cancelSubmit = true;
			$(form).submit();
			
			return false;
		}
		
		validate = form.validate({ errorPlacement: function(error, element) {} });
		
		// submit form
		if (validate)
			form.submit();
		else
			return false;
	});
	
	var w = $(window);
	var d = false;

	w.scroll(function() {
		var e = w.scrollTop() >= 44;
		var a = $("#header-bar, #header_banner");

		if (!d && e) {
			a.addClass("fixed");
			d = true
		} else if (d && !e) {
			a.removeClass("fixed");
			d = false
		}
	});

	function wrapperWidth() {
		//	var wrapper_width = $('body').width()-150;
		var wrapper_width = $('div.left-side').width();
		// wrapper_width = Math.floor(wrapper_width / 237) * 237;
		//		if (wrapper_width < 933) wrapper_width = 933;
		$('#wrapper').css('width', wrapper_width);
	}

	wrapperWidth();

	w.resize(function() {
		wrapperWidth();
	});

	var $container = $('#wrapper');
	
	if (typeof USE_MASONRY !== 'undefined' && USE_MASONRY)
	{
		$container.imagesLoaded(function() {
			$container.masonry({
				itemSelector : '.tack',
				columnWidth : 200,
				gutterWidth : 15
			});

			imwb_move_sidebar();
		});
	}
	
	$('.refresh-captcha').click(function(){
		// reload captcha
		jQuery('#img_captcha').attr('src', BASE_URL + 'index.php?option=com_hp_comment&task=captcha&rand=' + Math.floor((Math.random()*10000)+1));
		
		return false;
	});
	
	// comments
$('#hp-btn-post-comment').click(function(){
		
		var t = $(this);
		var comment = $('#hp-textarea-comment');
		var msg = $('#comment-msg');
		var guestFullName = $('#guest_fullname');
		var guestEmail = $('#guest_email');
		var captcha = $('#captcha_code');
		
		if (t.hasClass('processing'))
			return false;
		
		t.addClass('processing');
		
		// remove all error
		$('span.error').remove();
		
		var validForm = true;
		
		if (guestFullName.length && $.trim(guestFullName.val()) == '')
		{
			validForm = false;			
			guestFullName.after('<span class="error" style="padding-left: 5px;">Vui lòng nhập vào họ tên của bạn.</span>');
		}
		
		if (guestEmail.length)
		{
			if ($.trim(guestEmail.val()) == '')
			{
				validForm = false;				
				guestEmail.after('<span class="error" style="padding-left: 5px;">Vui lòng nhập vào email của bạn.</span>');
			}
			else
			{
				if (!isEmail(guestEmail.val()))
				{
					validForm = false;				
					guestEmail.after('<span class="error" style="padding-left: 5px;">Email không đúng.</span>');
				}
			}
		}
		
		if (captcha.length)
		{
			if ($.trim(captcha.val()) == '')
			{
				validForm = false;			
				captcha.after('<span class="error" style="padding-left: 5px;">Vui lòng nhập vào mã xác nhận.</span>');
			}
		}
		
		if ($.trim(comment.val()) == '')
		{
			validForm = false;		
			t.removeClass('processing');
			msg.removeClass('success').addClass('error').html('Vui lòng nhập vào thông tin bình luận của bạn');
		}
		
		if (!validForm)
		{
			t.removeClass('processing');
			return false;
		}
		
		msg.removeClass('error').html('Vui lòng đợi ...');
		
		$.post(
				'index.php?option=com_hp_comment&task=check_captcha',
				{ 'captcha_code': captcha.val() },
				function(res)
				{
					$('span.error').remove();
					
					if (res == 'OK')
					{
						$.post(
								BASE_URL + 'index.php?option=com_hp_comment&task=comment.post',
								/* ITEM_ID, ITEM_TYPE was defined in form */
								{
									content: comment.val(), 
									item_id: $('#item_id').val(), 
									item_type: $('#item_type').val(), 
									parent_id: $('#comment-parent-id').val(),
									guest_fullname: $.trim(guestFullName.val()),
									guest_email: $.trim(guestEmail.val()),
									guest_website: $.trim($('#guest_website').val()) 
								},
								function(res)
								{
									t.removeClass('processing');
									
									if (res == 'OK')
									{
										comment.val('');
										captcha.val('');
										
										// reload captcha
										jQuery('#img_captcha').attr('src', 'index.php?option=com_hp_comment&task=captcha&rand=' + Math.floor((Math.random()*10000)+1));
										
										msg.removeClass('error').addClass('success').html('Cảm ơn bạn. Bình luận của bạn đã được gửi!');
									}
									else
										msg.removeClass('success').addClass('error').html('Xin lỗi bạn. Có lỗi xảy ra. Vui lòng thử lại sau!');
										
								}
						);
					}
					else
					{
						t.removeClass('processing');
						
						msg.removeClass('error').html('');
						
						captcha.after('<span class="error" style="padding-left: 5px;">Mã xác nhận không đúng.</span>');
						
						// reload captcha
						jQuery('#img_captcha').attr('src', BASE_URL + 'index.php?option=com_hp_comment&task=captcha&rand=' + Math.floor((Math.random()*10000)+1));
					}
				}
			);
		
		
		
		return false;
	});
});