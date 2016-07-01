$(document).ready(function(){
	var window_Ht = $(window).height();
	$(".login_sec,.chat_page,.change_pwd_page").css("height",window_Ht);
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
		}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
	});
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
		}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
	});
});
$(window).resize(function(){
	var window_Ht = $(window).height();
	$(".login_sec,.chat_page,.change_pwd_page").css("height",window_Ht);
});