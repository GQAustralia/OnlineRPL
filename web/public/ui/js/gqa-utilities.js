// Transformicons
!function(n,r){"function"==typeof define&&define.amd?define(r):"object"==typeof exports?module.exports=r():n.transformicons=r()}(this||window,function(){"use strict";var n={},r="tcon-transform",t={transform:["click"],revert:["click"]},e=function(n){return"string"==typeof n?Array.prototype.slice.call(document.querySelectorAll(n)):"undefined"==typeof n||n instanceof Array?n:[n]},o=function(n){return"string"==typeof n?n.toLowerCase().split(" "):n},f=function(n,r,f){var c=(f?"remove":"add")+"EventListener",u=e(n),s=u.length,a={};for(var l in t)a[l]=r&&r[l]?o(r[l]):t[l];for(;s--;)for(var d in a)for(var v=a[d].length;v--;)u[s][c](a[d][v],i)},i=function(r){n.toggle(r.currentTarget)};return n.add=function(r,t){return f(r,t),n},n.remove=function(r,t){return f(r,t,!0),n},n.transform=function(t){return e(t).forEach(function(n){n.classList.add(r)}),n},n.revert=function(t){return e(t).forEach(function(n){n.classList.remove(r)}),n},n.toggle=function(t){return e(t).forEach(function(t){n[t.classList.contains(r)?"revert":"transform"](t)}),n},n});

/*!
	Autosize 3.0.20
	license: MIT
	http://www.jacklmoore.com/autosize
*/
!function(e,t){if("function"==typeof define&&define.amd)define(["exports","module"],t);else if("undefined"!=typeof exports&&"undefined"!=typeof module)t(exports,module);else{var n={exports:{}};t(n.exports,n),e.autosize=n.exports}}(this,function(e,t){"use strict";function n(e){function t(){var t=window.getComputedStyle(e,null);"vertical"===t.resize?e.style.resize="none":"both"===t.resize&&(e.style.resize="horizontal"),s="content-box"===t.boxSizing?-(parseFloat(t.paddingTop)+parseFloat(t.paddingBottom)):parseFloat(t.borderTopWidth)+parseFloat(t.borderBottomWidth),isNaN(s)&&(s=0),l()}function n(t){var n=e.style.width;e.style.width="0px",e.offsetWidth,e.style.width=n,e.style.overflowY=t}function o(e){for(var t=[];e&&e.parentNode&&e.parentNode instanceof Element;)e.parentNode.scrollTop&&t.push({node:e.parentNode,scrollTop:e.parentNode.scrollTop}),e=e.parentNode;return t}function r(){var t=e.style.height,n=o(e),r=document.documentElement&&document.documentElement.scrollTop;e.style.height="auto";var i=e.scrollHeight+s;return 0===e.scrollHeight?void(e.style.height=t):(e.style.height=i+"px",u=e.clientWidth,n.forEach(function(e){e.node.scrollTop=e.scrollTop}),void(r&&(document.documentElement.scrollTop=r)))}function l(){r();var t=Math.round(parseFloat(e.style.height)),o=window.getComputedStyle(e,null),i=Math.round(parseFloat(o.height));if(i!==t?"visible"!==o.overflowY&&(n("visible"),r(),i=Math.round(parseFloat(window.getComputedStyle(e,null).height))):"hidden"!==o.overflowY&&(n("hidden"),r(),i=Math.round(parseFloat(window.getComputedStyle(e,null).height))),a!==i){a=i;var l=d("autosize:resized");try{e.dispatchEvent(l)}catch(e){}}}if(e&&e.nodeName&&"TEXTAREA"===e.nodeName&&!i.has(e)){var s=null,u=e.clientWidth,a=null,p=function(){e.clientWidth!==u&&l()},c=function(t){window.removeEventListener("resize",p,!1),e.removeEventListener("input",l,!1),e.removeEventListener("keyup",l,!1),e.removeEventListener("autosize:destroy",c,!1),e.removeEventListener("autosize:update",l,!1),Object.keys(t).forEach(function(n){e.style[n]=t[n]}),i.delete(e)}.bind(e,{height:e.style.height,resize:e.style.resize,overflowY:e.style.overflowY,overflowX:e.style.overflowX,wordWrap:e.style.wordWrap});e.addEventListener("autosize:destroy",c,!1),"onpropertychange"in e&&"oninput"in e&&e.addEventListener("keyup",l,!1),window.addEventListener("resize",p,!1),e.addEventListener("input",l,!1),e.addEventListener("autosize:update",l,!1),e.style.overflowX="hidden",e.style.wordWrap="break-word",i.set(e,{destroy:c,update:l}),t()}}function o(e){var t=i.get(e);t&&t.destroy()}function r(e){var t=i.get(e);t&&t.update()}var i="function"==typeof Map?new Map:function(){var e=[],t=[];return{has:function(t){return e.indexOf(t)>-1},get:function(n){return t[e.indexOf(n)]},set:function(n,o){e.indexOf(n)===-1&&(e.push(n),t.push(o))},delete:function(n){var o=e.indexOf(n);o>-1&&(e.splice(o,1),t.splice(o,1))}}}(),d=function(e){return new Event(e,{bubbles:!0})};try{new Event("test")}catch(e){d=function(e){var t=document.createEvent("Event");return t.initEvent(e,!0,!1),t}}var l=null;"undefined"==typeof window||"function"!=typeof window.getComputedStyle?(l=function(e){return e},l.destroy=function(e){return e},l.update=function(e){return e}):(l=function(e,t){return e&&Array.prototype.forEach.call(e.length?e:[e],function(e){return n(e,t)}),e},l.destroy=function(e){return e&&Array.prototype.forEach.call(e.length?e:[e],o),e},l.update=function(e){return e&&Array.prototype.forEach.call(e.length?e:[e],r),e}),t.exports=l});


// jQuery tinyDraggable v1.0.2
// https://github.com/Pixabay/jQuery-tinyDraggable
!function(e){e.fn.tinyDraggable=function(n){var t=e.extend({handle:0,exclude:0},n);return this.each(function(){var n,o,u=e(this),a=t.handle?e(t.handle,u):u;a.on({mousedown:function(a){if(!t.exclude||!~e.inArray(a.target,e(t.exclude,u))){a.preventDefault();var f=u.offset();n=a.pageX-f.left,o=a.pageY-f.top,e(document).on("mousemove.drag",function(e){u.offset({top:e.pageY-o,left:e.pageX-n})})}},mouseup:function(){e(document).off("mousemove.drag")}})})}}(jQuery);


// Sticky containers
/*
 Sticky-kit v1.1.2 | WTFPL | Leaf Corcoran 2015 | http://leafo.net
*/
(function(){var b,f;b=this.jQuery||window.jQuery;f=b(window);b.fn.stick_in_parent=function(d){var A,w,J,n,B,K,p,q,k,E,t;null==d&&(d={});t=d.sticky_class;B=d.inner_scrolling;E=d.recalc_every;k=d.parent;q=d.offset_top;p=d.spacer;w=d.bottoming;null==q&&(q=0);null==k&&(k=void 0);null==B&&(B=!0);null==t&&(t="is_stuck");A=b(document);null==w&&(w=!0);J=function(a,d,n,C,F,u,r,G){var v,H,m,D,I,c,g,x,y,z,h,l;if(!a.data("sticky_kit")){a.data("sticky_kit",!0);I=A.height();g=a.parent();null!=k&&(g=g.closest(k));
if(!g.length)throw"failed to find stick parent";v=m=!1;(h=null!=p?p&&a.closest(p):b("<div />"))&&h.css("position",a.css("position"));x=function(){var c,f,e;if(!G&&(I=A.height(),c=parseInt(g.css("border-top-width"),10),f=parseInt(g.css("padding-top"),10),d=parseInt(g.css("padding-bottom"),10),n=g.offset().top+c+f,C=g.height(),m&&(v=m=!1,null==p&&(a.insertAfter(h),h.detach()),a.css({position:"",top:"",width:"",bottom:""}).removeClass(t),e=!0),F=a.offset().top-(parseInt(a.css("margin-top"),10)||0)-q,
u=a.outerHeight(!0),r=a.css("float"),h&&h.css({width:a.outerWidth(!0),height:u,display:a.css("display"),"vertical-align":a.css("vertical-align"),"float":r}),e))return l()};x();if(u!==C)return D=void 0,c=q,z=E,l=function(){var b,l,e,k;if(!G&&(e=!1,null!=z&&(--z,0>=z&&(z=E,x(),e=!0)),e||A.height()===I||x(),e=f.scrollTop(),null!=D&&(l=e-D),D=e,m?(w&&(k=e+u+c>C+n,v&&!k&&(v=!1,a.css({position:"fixed",bottom:"",top:c}).trigger("sticky_kit:unbottom"))),e<F&&(m=!1,c=q,null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),
h.detach()),b={position:"",width:"",top:""},a.css(b).removeClass(t).trigger("sticky_kit:unstick")),B&&(b=f.height(),u+q>b&&!v&&(c-=l,c=Math.max(b-u,c),c=Math.min(q,c),m&&a.css({top:c+"px"})))):e>F&&(m=!0,b={position:"fixed",top:c},b.width="border-box"===a.css("box-sizing")?a.outerWidth()+"px":a.width()+"px",a.css(b).addClass(t),null==p&&(a.after(h),"left"!==r&&"right"!==r||h.append(a)),a.trigger("sticky_kit:stick")),m&&w&&(null==k&&(k=e+u+c>C+n),!v&&k)))return v=!0,"static"===g.css("position")&&g.css({position:"relative"}),
a.css({position:"absolute",bottom:d,top:"auto"}).trigger("sticky_kit:bottom")},y=function(){x();return l()},H=function(){G=!0;f.off("touchmove",l);f.off("scroll",l);f.off("resize",y);b(document.body).off("sticky_kit:recalc",y);a.off("sticky_kit:detach",H);a.removeData("sticky_kit");a.css({position:"",bottom:"",top:"",width:""});g.position("position","");if(m)return null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.remove()),a.removeClass(t)},f.on("touchmove",l),f.on("scroll",l),f.on("resize",
y),b(document.body).on("sticky_kit:recalc",y),a.on("sticky_kit:detach",H),setTimeout(l,0)}};n=0;for(K=this.length;n<K;n++)d=this[n],J(b(d));return this}}).call(this);


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
	init: function() {
        $('[data-toggle="collapse"]').on("click", function(e){
              var $_target =  $(e.currentTarget);
              var $_panelBody = $_target.next(".panel-collapse");
              if($_panelBody){
                $_panelBody.collapse('toggle')
              }
        })

        TEXTAREA_AUTOHEIGHT.build();
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

	   //  var grd_height = height - gradient.height()

	  	// gradient.css({
	  	// 	top: ,
	  	// 	height: header.height()
	  	// });

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
		$('<div class="menu-overlay"></div>').insertAfter('#navLinks');

		var menu = $('#navLinks'),
			width = "-"+menu.width()+"px",
			overlay = $('.menu-overlay');

		transformicons.add('.tcon');

		function translateX() {
			if (GQA_HEADER.is_menu_open == false) { return ['0',width]; }
			else { return [width,'0']; }
		}

		function opacity() {
			if (GQA_HEADER.is_menu_open == false) { return 1; }
			else { return 0; }
		}

		function display() {
			if (GQA_HEADER.is_menu_open == false) {
				$('body').css('overflow','hidden');
				
				return 'block';
			}
			else {
				$('body').css('overflow','');
				$('.header-gqa-nav').removeClass('open')
				return 'none';
			}	
		}

		function animate() {

			menu.velocity({ translateX: translateX(),opacity: opacity() },
			{
				display: display(),
				duration: 500,
				easing: [0.550, 0.085, 0.000, 0.960],
				begin: function() {
					$('<div class="menu-overlay-no-click"></div>').appendTo('body');
					
					overlay.velocity({ opacity: opacity() },
					{
						display: display(),
						duration: 500,
						easing: [0.550, 0.085, 0.000, 0.960]
					});
				},
				complete: function() {
					if(GQA_HEADER.is_menu_open == false){
						GQA_HEADER.is_menu_open = true;
						$('.header-gqa-nav').addClass('open')
					}else{
						GQA_HEADER.is_menu_open = false
					}
					$('.menu-overlay-no-click').remove();
					
				}
			});	
		}
		
		$('#btnNavicon').on('click', animate);
		overlay.on('click', function(){ $('#btnNavicon').click(); });
	},
	build: function() {
		this.scroll();
		this.mobile_menu();
	}
}

// custom thumbnails division
var FILE_THUMBNAIL = {
	doc: $(document),
	compute: function(){

		var p = $('[data-has-thumbnail="true"]'),
			w = p.width(),
			group = $('.thumbnail-group'),
			thumbnail = $('.thumbnail-group-item'),
			header = $('.thumbnail-header'),
			xs = 480,
			sm = 600,
			md = 768,
			lg = 1024,
			xlg = 1140;

		function listView() {
			if (group.hasClass('list-view')) { return true ; }
			else { return false; }
		}

		if (listView() == true) {
			header.css('height','');
			thumbnail.css('width','');
			return false;
		}
		else {
			if(w <= xs){ division(2); }
			else if(w <= sm){ division(4); }
			else if(w <= md){ division(5); }
			else if(w <= lg){ division(6); }
			else if(w <= xlg){ division(7); }
			else { division(8); }	
		}

		function division(value){
			thumbnail.css({
				'width': 100 / value + '%'
			});
			header.css('height', thumbnail.width());
		}

		console.log();
	},
	resize: function() {
		var t;
		$(window).on('resize', function() {
			clearTimeout(t);
			t = setTimeout(function(){
				FILE_THUMBNAIL.compute();
				GQA_FOOTER.handle_footer();
			},100);
		});
	},
	build: function(){
		// FILE_THUMBNAIL.file_name_width();
		FILE_THUMBNAIL.resize();
		FILE_THUMBNAIL.compute();
	}
}
var GQA_FOOTER =  {
	doc: $(document),
	watch: function() {
		function onElementHeightChange(elm, callback){
			var lastHeight = elm.clientHeight, newHeight;
			(function run(){
				newHeight = elm.clientHeight;
				if( lastHeight != newHeight )
					callback();
				lastHeight = newHeight;

		        if( elm.onElementHeightChangeTimer )
		          clearTimeout(elm.onElementHeightChangeTimer);

				elm.onElementHeightChangeTimer = setTimeout(run, 100);
			})();
		}

		onElementHeightChange(document.body, function(){
			GQA_FOOTER.handle_footer();
		});
	},
	handle_footer: function() {
		var wh = $(window).height(),
			body = $('body'),
		    bh = body.height(),
		    footer = $('[data-toggle="auto-fixed-footer"]');

		if (bh > wh) {
			body.css('paddingBottom','');
			footer.removeClass('navbar-fixed-bottom');
		}
		else {
			body.css('paddingBottom', footer.height() + 15);
			footer.addClass('navbar-fixed-bottom');
		}
	},
	resize: function() {
		this.doc.on('resize', function(event) {
			GQA_FOOTER.handle_footer();
		});
	},
	build: function() {
		this.resize();
		this.handle_footer();
	}
}

var BTN_LOADER = {
	doc: $(document),
	markup: '<i class="zmdi zmdi-setting zmdi-hc-spin"></i>',
	init: function() {
		this.doc.on('click', '.btn-loader', function(event) {
			$(document).ajaxStop(function() {
				BTN_LOADER.hide_loading($(this));
			});

			BTN_LOADER.display_loading($(this));
		});


	},
	display_loading: function(object) {
		object.html().detach();
		object.append(BTN_LOADER.markup);
	},
	hide_loading: function(object) {
		object.html().detach();
		object.append(BTN_LOADER.markup);
	},
	build: function() {
		this.init();
	}
}

var WRAP_API_TABLE = {
	table : $('.content-from-api table'),
	wrap_table: function(){
		this.table.wrap('<div class="content-table"></div>')
	},
	build: function(){
		WRAP_API_TABLE.wrap_table();
	}
}

// custom dropdown picker
var DROPDOWN_PICKER = {
    doc: $(document),
    init: function() {
        this.doc.on('click', '[data-toggle="dropdown-picker"] li',function(event) {
            $(this).addClass('active').siblings().removeClass('active');
            $('#dropdownSelected').html($(this).text());
        });
        this.doc.on('click', '[data-toggle="dropdown-picker"] li a',function(event) {
            event.preventDefault();
        });
    },
    build: function() {
        this.init();
    }
}

// auto height if textarea as user types
var TEXTAREA_AUTOHEIGHT = {
	build: function(){
		autosize($('textarea'));
	}
}

var MYTASKS = {
    doc: $(document),
    btn: $('#showAllTasks'),
    close: $('#hideMyTasks'),
    panel: $('#floatingMyTasks'),
    easing: [0.550, 0.085, 0.000, 0.960],
    is_open: false,
    init: function() {
	    MYTASKS.btn.on('click', function() {

	    	if (!$(this).hasClass('animating')) {
		    	if (MYTASKS.is_open === false) { 
		    		MYTASKS.open();
		    		MYTASKS.is_open = true;
		    	}
		    	else { 
		    		MYTASKS.hide();
		    		MYTASKS.is_open = false;
		    	}
	    	}
	    	$(this).addClass('animating');
	    });
	    MYTASKS.close.on('click', function() {
	        MYTASKS.hide();
	        MYTASKS.is_open = false;
	    });

	    MYTASKS.panel.tinyDraggable({ handle: '#floatingMyTasksHandle' });
    },
    open: function() {
        MYTASKS.panel.velocity(
        	{ opacity: 1, translateY: ['0','30px'] },
        	{ display: 'block', duration: 500, easing: MYTASKS.easing, 
        		complete: function() { 
        			MYTASKS.btn.removeClass('animating');
        		}
        	});
    },
    hide: function() {
        MYTASKS.panel.velocity(
        	{ opacity: 0, translateY: '30px' },
        	{ display: 'none', duration: 500, easing: MYTASKS.easing, 
        		complete: function() { 
        			MYTASKS.btn.removeClass('animating');
        		}
        	});
    },
    build: function() {
        MYTASKS.init();
    }
}

// has error fields
var HAS_ERROR = {
	has_error: '.has-error',
	init_tooltip: function(){
		$('[data-toggle="tooltip"]').tooltip();
	},
	focus: function(){
		$(document).on('blur', this.has_error + ' input, '+ this.has_error + ' select', function(){
			removeHasError($(this));
		})

		$(document).on('click', this.has_error + ' .btn-group .btn', function(){
			removeHasError($(this));
		})

		function removeHasError(elem){
			$(elem).closest('.has-error').removeClass('has-error').find('i[data-toggle="tooltip"]').remove();
		}
	},
	build: function(){
		HAS_ERROR.init_tooltip();
		HAS_ERROR.focus();
	}
}


// Initialize Global UI elements 
var GLOBAL_UI = {
	handle_layout: function() {
		var ismobile = isMobile.phone,
			body = $('body');

		if (isMobile.phone === true) {
			body.addClass('is-mobile')
		}
		else if (isMobile.tablet === true) {
			body.addClass('is-tablet');
		}
		else if (isMobile.tablet === false && isMobile.tablet === false) {
			body.addClass('is-desktop');
		}

		$('[data-toggle="tab"]').on('click', function() {
			GQA_FOOTER.handle_footer();
		});

		$('[data-toggle="toggle"]').on('click', function() {
			var target = $(this).data('target');

			if (isMobile.phone === true) {
				$(target).toggle();
				$(this).toggleClass('open');
			}
		});
	},
    display_search: function(elem) {
        $(elem).parent().addClass('focused');
    },
    hide_search: function(elem) {
        if ($(elem).val() === '') {
            $(elem).parent().removeClass('focused');
        }
    },
	get_current_year: function() {
        var d = new Date(), n = d.getFullYear();
        $('#currentYear').html(n);
	},
	bootstrap_init: function() {
		$('[data-toggle="tooltip"]').tooltip({
			animation: false
		});
	},
	init: function() {
		this.handle_layout();
		this.get_current_year();
		this.bootstrap_init();
		// BTN_LOADER.build();

		HAS_ERROR.build();
		GQA_HEADER.build();
		GQA_FOOTER.watch();
	}
}


$(document).ready(function() {
	GLOBAL_UI.init();
});

$(window).load(function(){
	WRAP_API_TABLE.build();
})

// // CSS Pointer-events: none Polyfill
// function PointerEventsPolyfill(t){if(this.options={selector:"*",mouseEvents:["click","dblclick","mousedown","mouseup"],usePolyfillIf:function(){if("Microsoft Internet Explorer"==navigator.appName){var t=navigator.userAgent;if(null!=t.match(/MSIE ([0-9]{1,}[\.0-9]{0,})/)){var e=parseFloat(RegExp.$1);if(11>e)return!0}}return!1}},t){var e=this;$.each(t,function(t,n){e.options[t]=n})}this.options.usePolyfillIf()&&this.register_mouse_events()}PointerEventsPolyfill.initialize=function(t){return null==PointerEventsPolyfill.singleton&&(PointerEventsPolyfill.singleton=new PointerEventsPolyfill(t)),PointerEventsPolyfill.singleton},PointerEventsPolyfill.prototype.register_mouse_events=function(){$(document).on(this.options.mouseEvents.join(" "),this.options.selector,function(t){if("none"==$(this).css("pointer-events")){var e=$(this).css("display");$(this).css("display","none");var n=document.elementFromPoint(t.clientX,t.clientY);return e?$(this).css("display",e):$(this).css("display",""),t.target=n,$(n).trigger(t),!1}return!0})};
// $(document).ready(function() { PointerEventsPolyfill.initialize({}); });
