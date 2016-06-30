$(document).ready(function(){
	var window_Ht = $(window).height();
	$(".mobile_version").css("height",window_Ht);
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
		}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
	});
	
	$("#uploadTrigger").click(function(){
	   $("#uploadFile").click();
	});
	
	$(".mobile_version .reply_link").click(function(){
		$(this).hide();
		$("textarea").show();
	});
	
	var textarea_ht = window_Ht - 135;
	$(".mobile_version .new_msg_section textarea").css("height",textarea_ht);
});
$(window).resize(function(){
	var window_Ht = $(window).height();
	$(".mobile_version").css("height",window_Ht);
	
	var textarea_ht = window_Ht - 135;
	$(".mobile_version .new_msg_section textarea").css("height",textarea_ht);
});

 