// Profile page upload icon animation
var UPLOAD_ICON_ANIMATION = {
	elem: $('#uploadAvatar'),
	animate: function(scale_value) {
		this.elem.next('i').velocity({scale: scale_value}, 200)
	},
	hover: function() {
		this.elem.on({
			'mouseenter': function(){UPLOAD_ICON_ANIMATION.animate(1.2);},
			'mouseleave': function(){UPLOAD_ICON_ANIMATION.animate(1.0);}
		})
	},
	build: function() {UPLOAD_ICON_ANIMATION.hover();}
}

$(function(){
	UPLOAD_ICON_ANIMATION.build();
})