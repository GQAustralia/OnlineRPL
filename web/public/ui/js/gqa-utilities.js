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

var OPACITY_SCROLL = {
	scroll: function() {
		var bg = $('#navImg'),
			gradient = $('#navGradient'),
			header = $('#headerGQA');

		var range = 100;
		$(window).on('scroll', function () {
		  
		    var scrollTop = $(this).scrollTop();
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
		});
	},
	build: function() {
		this.scroll();
	}
}


//Rotating accordion arrow
var ANIMATE_ARROW = {
	elem: $('.collapse'),
	collapse: function() {
		this.elem.on('show.bs.collapse hide.bs.collapse', function() {
			$(this).prev('.panel-heading').find('i').velocity({rotateZ: '+=180'}, 300)
		})
	},
	build: function() {
		ANIMATE_ARROW.collapse();
	}
}

// // CSS Pointer-events: none Polyfill
// function PointerEventsPolyfill(t){if(this.options={selector:"*",mouseEvents:["click","dblclick","mousedown","mouseup"],usePolyfillIf:function(){if("Microsoft Internet Explorer"==navigator.appName){var t=navigator.userAgent;if(null!=t.match(/MSIE ([0-9]{1,}[\.0-9]{0,})/)){var e=parseFloat(RegExp.$1);if(11>e)return!0}}return!1}},t){var e=this;$.each(t,function(t,n){e.options[t]=n})}this.options.usePolyfillIf()&&this.register_mouse_events()}PointerEventsPolyfill.initialize=function(t){return null==PointerEventsPolyfill.singleton&&(PointerEventsPolyfill.singleton=new PointerEventsPolyfill(t)),PointerEventsPolyfill.singleton},PointerEventsPolyfill.prototype.register_mouse_events=function(){$(document).on(this.options.mouseEvents.join(" "),this.options.selector,function(t){if("none"==$(this).css("pointer-events")){var e=$(this).css("display");$(this).css("display","none");var n=document.elementFromPoint(t.clientX,t.clientY);return e?$(this).css("display",e):$(this).css("display",""),t.target=n,$(n).trigger(t),!1}return!0})};
// $(document).ready(function() { PointerEventsPolyfill.initialize({}); });
