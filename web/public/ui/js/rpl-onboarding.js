$(document).ready(function(){
	ONBOARDING_CAROUSEL.build();
	ONBOARDING_NEXT_STEP.build();
})

// Initialize onboarding modal's owl carousel on mobile mode
var ONBOARDING_CAROUSEL = {
	init: function(){
		$('.owl-carousel').owlCarousel({
			autoHeight: true,
			loop: true,
			autoplay: true,
			fluidSpeed: 2000,
		    responsive: {
		        0: {
		            items: 1
		        },
		        480: {
		        	items: 2
		        },
		        768: {
		        	items: 3
		        }
		    }
		});
	},
	bind: function(){

		if (isMobile.phone){
			ONBOARDING_CAROUSEL.init();
			$('.modal-onboarding .col-sm-7').addClass('hide')
		} else {
			$('.owl-carousel .col-sm-4').css('hide')
		}
	},
	build: function(){
		$('#onboardingModal').modal('show');
		
		ONBOARDING_CAROUSEL.bind();
	}
}

var ONBOARDING_NEXT_STEP = {
	terms: $('#termsAndConditions'),
	button: $('#nextStep'),
	token: $('#loginToken'),
	error: $('#errorMessage'),
	errormsg: $('#errorMessage span'),
	bind: function(){
		ONBOARDING_NEXT_STEP.terms.on('change', function(){ONBOARDING_NEXT_STEP.control_submit_button()});
		ONBOARDING_NEXT_STEP.button.on('click', function(){ONBOARDING_NEXT_STEP.validate_terms()});
	},
	control_submit_button: function(){
		if(this.terms.is(':checked')){this.button.prop('disabled', false)}
		else{this.button.prop('disabled', true)};
	},	
	validate_terms: function(){
		if(this.terms.is(':checked')){this.accept_onboarding()}
		else{this.error_action('Please read the the RPL Information Kit.')};
	},
	accept_onboarding: function(){
		var btntext = '<i class="zmdi zmdi-settings zmdi-hc-spin"></i> Processing';
			ONBOARDING_NEXT_STEP.button.attr('disabled',true).html(btntext);
		$.ajax({
			url: '/acceptOnBoardingAjax',
			type: 'POST',
			data: { 'loginToken' : ONBOARDING_NEXT_STEP.token.val() },
		})
		.success(function(data) {
			window.location.href = "/enrolment";
			ONBOARDING_NEXT_STEP.button.attr('disabled',false).html('<span class="text-uppercase">Next Step:</span> Online Enrolment');
		})
		.fail(function() {
			ONBOARDING_NEXT_STEP.error_action('Sorry, we are unable to process this request. Please try again later.');
			ONBOARDING_NEXT_STEP.button.attr('disabled',false).html('<span class="text-uppercase">Next Step:</span> Online Enrolment');
		})
	},
	error_action: function(error_msg){
		var errormsg = ONBOARDING_NEXT_STEP.errormsg,
			error = ONBOARDING_NEXT_STEP.error,
			button = ONBOARDING_NEXT_STEP.button;

		error.removeClass('hidden');
		errormsg.html(error_msg);
		button.velocity('callout.shake');
	},
	build: function(){
		ONBOARDING_NEXT_STEP.bind();
	}
}
