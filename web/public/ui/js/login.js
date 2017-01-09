var LOGIN = {
	box: $('#loginContainer'),
	footer: $('#footerLogin'),
	set_dimensions: function() {
		LOGIN.box.height($(window).outerHeight() - 15).width($(window).outerWidth());

		var offset_height = $('.panel-login').outerHeight() + LOGIN.footer.height() + 70;

		if (offset_height > $(window).height()) {
			LOGIN.footer.addClass('relative').removeClass('fixed');
			$('.panel-login').css('marginTop','0');
		}
		else {
			$('.panel-login').removeAttr('style');
			LOGIN.footer.addClass('fixed').removeClass('relative');
		}
	},
	resize: function() {
		$(window).on('resize', function(event) {
			LOGIN.set_dimensions();
		});
	},
	handle_layout: function() {
		var ismobile = isMobile.phone;
		ismobile === true ? $('body').addClass('is-mobile') : $('body').addClass('is-desktop is-tablet');
	},
	get_current_year: function() {
        var d = new Date(), n = d.getFullYear();
        $('#currentYear').html(n);
	},
	build: function() {
		LOGIN.get_current_year();
		LOGIN.handle_layout();
		LOGIN.resize();
		LOGIN.set_dimensions();
	}
}

$(document).ready(function() {
	TOGGLE_PASSWORD.build();
	LOGIN.build();	
});