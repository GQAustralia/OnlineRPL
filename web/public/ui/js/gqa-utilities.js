// Toggle Visibility of a Password Field
var TOGGLE_PASSWORD = {
	doc: $(document),
	bind: function() {
		this.doc.on('click', '[data-target="password"]', function(event) {  
			TOGGLE_PASSWORD.toggle_input($(this));
		});
	},
	toggle_input: function(elem) {
		var input_pass = elem.prev('*[data-element="password"]');
		if (input_pass.attr('type') === 'password') {
			elem.find('i').removeClass('zmdi-eye').addClass('zmdi-eye-off');
			input_pass.attr('type', 'text');
		}

		else if (input_pass.attr('type') === 'text') {
			elem.find('i').removeClass('zmdi-eye-off').addClass('zmdi-eye');
			input_pass.attr('type', 'password');
		}
	},
	build: function(){ 
		if (this.doc.find('[data-target="password"]').length) TOGGLE_PASSWORD.bind();
	}
}

// control collapse behavior for "yes / no" fields
var CONTROL_COLLAPSE = {
	elem: $('[data-collapse]'),
	collapse: function(){
		this.elem.on('click', function(){
			var target= $(this).data('target'),
				show = 'show',
				hide = 'hide';
			if($(this).data('collapse') === show){
				$(target).collapse(show)
			}else{
				$(target).collapse(hide)
			}
		})
	},
	build: function(){
		CONTROL_COLLAPSE.collapse();
	}
}

// Collapse Read More
var READ_MORE = {
	doc: $(document),
	bind: function() {
		this.doc.on('click', '*[data-target="read-more"]', function() {  READ_MORE.expand($(this)); });
	},
	expand: function(elem) {
		elem.find('.read-more').removeClass('read-more');
		elem.find('.trigger-read-more').remove();
	},
	build: function(){ this.bind(); }
}

var GQA_HEADER = {
	is_menu_open: false,
	scroll: function() {
		var bg = $('#navImg'),
			gradient = $('#navGradient'),
			header = $('#headerGQA');

		var range = 100;
		$(window).on('scroll', function () {
			var scrollTop = $(this).scrollTop();

			if (isMobile.phone === true) {
				GQA_HEADER.mobile_scroll(scrollTop,bg,gradient,header,range);
			}
			else {
				GQA_HEADER.non_mobile_scroll(scrollTop,bg,gradient,header,range);
			}
		});
	},
	mobile_scroll: function(scrollTop,bg,gradient,header,range) {

	},
	non_mobile_scroll: function(scrollTop,bg,gradient,header,range) {
	    var offset = bg.offset().top;
	    var height = bg.outerHeight();
	    offset = offset + height / 2;

	    var calc_img = 1 - (scrollTop - offset + range) / range; // for background image
	    	calc_grd = 0 + (scrollTop - offset + range) / range; // for background gradient

	  
	    bg.fadeTo(0, calc_img);
	    gradient.fadeTo(0, calc_grd);
	  
	    if ( calc_img > '1' ) { bg.fadeTo(0, 1); }
	    else if ( calc_img < '0' ) { bg.fadeTo(0, 0); }

	    if ( calc_grd > '1' ) {
	    	gradient.fadeTo(0, 1);
	    	header.addClass('compressed');
	    }
	    else if ( calc_grd < '0' ) {
	    	gradient.fadeTo(0, 0);
	    	header.removeClass('compressed');
	    }
	},
	mobile_menu: function() {
		var menu = $('#navLinks'),
			width = "-"+menu.width()+"px";

		// Transformicons
		!function(n,r){"function"==typeof define&&define.amd?define(r):"object"==typeof exports?module.exports=r():n.transformicons=r()}(this||window,function(){"use strict";var n={},r="tcon-transform",t={transform:["click"],revert:["click"]},e=function(n){return"string"==typeof n?Array.prototype.slice.call(document.querySelectorAll(n)):"undefined"==typeof n||n instanceof Array?n:[n]},o=function(n){return"string"==typeof n?n.toLowerCase().split(" "):n},f=function(n,r,f){var c=(f?"remove":"add")+"EventListener",u=e(n),s=u.length,a={};for(var l in t)a[l]=r&&r[l]?o(r[l]):t[l];for(;s--;)for(var d in a)for(var v=a[d].length;v--;)u[s][c](a[d][v],i)},i=function(r){n.toggle(r.currentTarget)};return n.add=function(r,t){return f(r,t),n},n.remove=function(r,t){return f(r,t,!0),n},n.transform=function(t){return e(t).forEach(function(n){n.classList.add(r)}),n},n.revert=function(t){return e(t).forEach(function(n){n.classList.remove(r)}),n},n.toggle=function(t){return e(t).forEach(function(t){n[t.classList.contains(r)?"revert":"transform"](t)}),n},n});		

		$('#btnNavicon').click(function() {
			// transformicons.add('.tcon');
			// transformicons.toggle($('#btnNavicon'));

			function translateX() {
				if (GQA_HEADER.is_menu_open == false) { return ['0',width]; }
				else { return [width,'0']; }
			}

			function opacity() {
				if (GQA_HEADER.is_menu_open == false) { return 1; }
				else { return 0; }
			}

			menu.velocity({
				translateX: translateX(),
				opacity: opacity()
			},
			{
				display: 'block',
				duration: 500,
				easing: [0.550, 0.085, 0.000, 0.960],
				complete: function() {
					GQA_HEADER.is_menu_open == false ? GQA_HEADER.is_menu_open = true : GQA_HEADER.is_menu_open = false;
				}
			});
		});
	},
	build: function() {
		this.scroll();
		this.mobile_menu();
	}
}


//Rotating accordion arrow
var ANIMATE_ARROW = {
	elem: $('.panel-collapse'),
	open: false,
	collapse: function() {
		ANIMATE_ARROW.elem.on('show.bs.collapse hide.bs.collapse', function() {
			var chevron = $(this).prev('.panel-heading').find('i');

			if (ANIMATE_ARROW.open !== true) {
				chevron.velocity({rotateZ: '180'}, { 
					duration: 300, 
					complete: function() { 
						ANIMATE_ARROW.open = true;
					}
				});
			}
			else {
				chevron.velocity('reverse');
				ANIMATE_ARROW.open = false;
			}
		})
	},
	build: function() {
		ANIMATE_ARROW.collapse();
	}
}

// Initialize Global UI elements 
var GLOBAL_UI = {
	handle_layout: function() {
		var ismobile = isMobile.phone;
		ismobile === true ? $('body').addClass('is-mobile') : $('body').addClass('is-desktop is-tablet');
	},
	get_current_year: function() {
        var d = new Date(), n = d.getFullYear();
        $('#currentYear').html(n);
	},
	init: function() {
		this.handle_layout();
		this.get_current_year();
		ANIMATE_ARROW.build();
		GQA_HEADER.build();
	}
}

$(document).ready(function() {
	GLOBAL_UI.init();
});

// // CSS Pointer-events: none Polyfill
// function PointerEventsPolyfill(t){if(this.options={selector:"*",mouseEvents:["click","dblclick","mousedown","mouseup"],usePolyfillIf:function(){if("Microsoft Internet Explorer"==navigator.appName){var t=navigator.userAgent;if(null!=t.match(/MSIE ([0-9]{1,}[\.0-9]{0,})/)){var e=parseFloat(RegExp.$1);if(11>e)return!0}}return!1}},t){var e=this;$.each(t,function(t,n){e.options[t]=n})}this.options.usePolyfillIf()&&this.register_mouse_events()}PointerEventsPolyfill.initialize=function(t){return null==PointerEventsPolyfill.singleton&&(PointerEventsPolyfill.singleton=new PointerEventsPolyfill(t)),PointerEventsPolyfill.singleton},PointerEventsPolyfill.prototype.register_mouse_events=function(){$(document).on(this.options.mouseEvents.join(" "),this.options.selector,function(t){if("none"==$(this).css("pointer-events")){var e=$(this).css("display");$(this).css("display","none");var n=document.elementFromPoint(t.clientX,t.clientY);return e?$(this).css("display",e):$(this).css("display",""),t.target=n,$(n).trigger(t),!1}return!0})};
// $(document).ready(function() { PointerEventsPolyfill.initialize({}); });
