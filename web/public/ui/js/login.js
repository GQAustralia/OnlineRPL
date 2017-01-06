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

var AUTH = {
	doc: 		$(document),
	username: 	$('#username'),
	password: 	$('#currentpassword'),
	button: 	$('#submitAuth'),
	error: 		$('#errorMessage'),
	errormsg: 	$('#errorMessage span'),
	rememberMe: $('#rememberCredential'),

	bind: function() {
		this.doc.on('click', '#submitAuth', AUTH.validate_fields );
		this.doc.on('click', '#logoutUser', AUTH.log_out );

		this.doc.on('click', '#rememberCredential', AUTH.remember_me);

		$('#userAccountName').html(localStorage.getItem('name'));

		this.doc.on('blur', '#username', AUTH.remember_me);
		this.doc.on('blur', '#currentpassword', AUTH.remember_me);
	},
	submit_enter: function() {
		$(document).on('keyup', '#username, #currentpassword', function(event) {
		    if(event.keyCode == 13){
		        AUTH.validate_fields();
		        AUTH.remember_me();
		    }
		});
	},
	check_if_remembered: function() {
		var stored_username = localStorage.getItem('fsrusername'),
			stored_password = localStorage.getItem('fsrpassword');

		if ((stored_username !== null && stored_password !== null) || (AUTH.username.val() !== '' && AUTH.password.val() !== '')) {
			AUTH.username.val(stored_username);
			AUTH.password.val(stored_password);
			AUTH.rememberMe.prop('checked',true);
		}
		else {
			AUTH.username.val('');
			AUTH.password.val('');
			AUTH.rememberMe.prop('checked',false);
		}
	},
	remember_me: function() {
		function checked() {
			localStorage.setItem('fsrusername',AUTH.username.val());
			localStorage.setItem('fsrpassword',AUTH.password.val());
		}

		function unchecked() {
			localStorage.removeItem('fsrusername');
			localStorage.removeItem('fsrpassword');	
		}

		if (AUTH.rememberMe.is(':checked')) { checked(); }
		else { unchecked(); }
	},
	validate_fields: function() {
		if (areFieldsValid() === 'valid') { 
			AUTH.log_in();
		}
		else {
			AUTH.error.removeClass('hidden');
			AUTH.button.velocity('callout.shake');
		}

		function areFieldsValid() {
			var validity = 'invalid',
				pattern = /\s/g,
				email_pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
				user_has_space = pattern.test(AUTH.username.val()),
				pass_has_space = pattern.test(AUTH.password.val());
				email_format = email_pattern.test(AUTH.username.val());

			if (AUTH.username.val().length > 0 && email_format === false) {
				AUTH.errormsg.html('Incorrect email format');
				validity = 'invalid';
			}
			else if (AUTH.username.val().length > 0 && AUTH.password.val().length > 0 && email_format !== false) {
				if (user_has_space === false && pass_has_space === false) {
					validity = 'valid';
				}
				else {
					AUTH.errormsg.html('Login credentials should not have spaces.');
					validity = 'invalid';
				}
			}
			else {
				AUTH.errormsg.html('Login credentials should not be left blank.');
				isValid = 'invalid';
			}
			return validity;
		}
	},
	log_in: function() {

		var username = AUTH.username.val(),
			password = AUTH.password.val();

		var btntext = '<i class="zmdi zmdi-settings zmdi-hc-spin"></i> Logging in...';

		AUTH.button.attr('disabled',true).html(btntext);

		// $.ajax({
		// 	url: '',
		// 	type: 'POST',
		// 	data: { "username" : username, "password" : password }
		// })
		// .success(function(data) {
		// 	if (data.response === 200) {

		// 		localStorage.setItem('token',data.token);
		// 		localStorage.setItem('name', data.name);

		// 		AUTH.error.addClass('hidden');
		// 		AUTH.button.attr('disabled',false).html('Log In');
		// 		window.location.href = ''; // replace with whatever URL
		// 	}
		// })
		// .fail(function(xhr, status, error) {
		// 	if (xhr.status === 404) {
		// 		AUTH.error.text('Invalid username or password');
		// 	}
		// 	else {
		// 		AUTH.error.text(xhr.responseJSON.message);
		// 	}
			
		// 	AUTH.error.removeClass('hidden');
		// 	AUTH.button.velocity('callout.shake');
		// 	AUTH.button.attr('disabled',false).html('Log In');
		// })
		// .always(function() {
		// 	LOADER.hide();
		// });
	},

	log_out: function() {
		var token = localStorage.getItem('token');

		$.ajax({
			url: UTILS.url('logout'),
			type: 'GET',
			data: { "token" : token }
		})
		.always(function() {
			localStorage.removeItem('token');
			localStorage.removeItem('fsrid');
			// window.location.replace('index.html');
		})
	},
	get_name: function() {
		var name = localStorage.getItem('name');

		$('#userAccountName').html(name);
	},
	build: function() {
		this.bind();
		this.submit_enter();
		this.check_if_remembered();
	}
}

$(document).ready(function() {
	TOGGLE_PASSWORD.build();
	LOGIN.build();
	AUTH.build();
});