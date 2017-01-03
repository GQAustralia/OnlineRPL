$(document).ready(function(){
	IS_MOBILE.build();
	ONBOARDING_CAROUSEL.build();
})

$(window).load(function(){
	$('#onboardingModal').modal('show');
})

//Add class is-mobile to 'body' on mobile mode
var IS_MOBILE = {
	bind: function(){
		isMobile.phone === true ? $('body').addClass('is-mobile') : $('body').removeClass('is-mobile').addClass('is-desktop')
	},
	build: function(){
		IS_MOBILE.bind();
	}
}

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
		ONBOARDING_CAROUSEL.bind();


	}
}