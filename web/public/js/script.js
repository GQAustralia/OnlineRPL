$(document).ready(function(){
	var window_Ht = $(window).height();
	$(".main_container,.mobile_version ").css("height",window_Ht);
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
		}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
	});
});
$(window).resize(function(){
	var window_Ht = $(window).height();
	$(".main_container,.mobile_version ").css("height",window_Ht);
});

