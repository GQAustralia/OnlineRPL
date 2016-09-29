var modEle;
$(document).ready(function(){

    /* script for IE custom select option icon */
    
    /*var uA = navigator.userAgent;
    
    if((uA.indexOf('Trident') != -1 && uA.indexOf('rv:11') != -1) || uA.indexOf('MSIE ')>0) {
        var selectArrowH=tml='<i class="material-icons select-option-arrow">arrow_drop_down</i>';
        $("#selectOptionBox").append(selectArrowH);
    }*/
    
    
    /* header menu js starts*/
    var menuEle=null;
        var isShow=false;

        $(".profile").on("click", function(evt){
            if(isShow){
                isShow=false;
            }else{
                 menuEle=  $(this).children('ul');
                $(menuEle).toggleClass("show hide");
                 setTimeout(addEventForDoc($(this)),2000);   
                isShow=true;
            }
        });

        /* header for manager Roles */
	$(".hamburger-menu").on("click", function(){
            $(".manager-nav").toggleClass("show hide");
        });
        
        function addEventForDoc(reqEle){
            $(document).on("mouseup", function(evt){
                if(menuEle==null)
                {
                    evt.preventDefault();
                    return false;
                }else{
                   $(menuEle).toggleClass("show hide");
                    setTimeout(function(){isShow=false;},500);
                }
                menuEle=null;    
            });
        };
    
    /* header menu js ends*/

        
    /* Candidate Details */
	 
    /*$('.candidate-details').hide();
    $('.info-header').hide();

    function showHideUserProfile(reqValue){
        if(reqValue){
               $('.candidate-details').show();
               $('.info-header').show();
        }else{
               $('.candidate-details').hide();
               $('.info-header').hide();
        }
    }
    $('.clickForMobileView').on('click',function(){
        $('.portfolio-container').hide();
        showHideUserProfile(true);
     });

     $('.closeprofile').on('click',function(){
             $('.portfolio-container').show();
             showHideUserProfile(false);
     });
      */  
	var window_Ht = $(window).height();
	var window_Wt = $(window).width();
	var header_Ht = $("header").height();
	var footer_Ht = $(".mobi-profile").height();
	var mobile_view_Ht = window_Ht - header_Ht - footer_Ht;
	var mobile_view_Ht1 = window_Ht - footer_Ht;
	
	$(".mobile_version").css("position","relative");
	$(".mobile_version,.login_page").css("height",window_Ht);
	$(".message_section .mobile_version,.mobile_version .mail_secion,.mobile_version .new_message_section").css("height",mobile_view_Ht);
	
	if(window_Wt >= 320 && window_Ht < 767){
		$('.main_container .step_list').css("height",window_Ht);
		$('.body_section,.portfolio-container').css("height",mobile_view_Ht);
		$('.candidate-details .body_section').css("height",mobile_view_Ht1);
		$(".change_link").click(function(){
			$(".body_section.candidate_profile").css("height",window_Ht);
		});
		$(".clear_pswd_div").click(function(){
			$(".body_section.candidate_profile").css("height",mobile_view_Ht);
		});
	}
	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
		}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
	});
	
	var newTitle_Ht = $(".mobile_version .new_message_section .title_bar").height();
	var inputField_Ht = $(".input_section").outerHeight() * 2;
	var sendBtnSection_Ht = $(".mobile_version .new_message_section .btn_section").height();
	var textarea_ht = window_Ht - (newTitle_Ht + inputField_Ht + sendBtnSection_Ht);
	$(".mobile_version .new_msg_section textarea").css("height",textarea_ht);
	
	if(window_Wt < 530 && window_Ht >= 480){
		$("#profile1 .modal-body").css("height",window_Ht);
		$("#profile1 .submit_btn").css("position","absolute");
	}
	
	if(window_Ht < 768){
		$(".add-evidence .modal-body").css("height",window_Ht);
	}
	
	if(window_Wt < 767 && window_Ht > 480){
		$(".transparent_popup .modal-dialog .modal-body").css("height",window_Ht);
		$(".modal.transparent_popup .modal-dialog .modal-content .login .form .submit_btn").css("position","absolute");
		$("#newUserupdatePassword .modal-dialog .modal-body").css("padding-top","20px");
	}
	
	if(window_Wt < 767 && window_Ht > 375){
		$("#onboard2 .modal-dialog .modal-body").css("height",window_Ht);
		$(".modal.transparent_popup .modal-dialog .step_list .btn_section").css("position","absolute");
	}
	
	/*if(window_Wt < 767 && window_Ht > 370){
		$(".login_section .login_btn").css("position","absolute");
	}*/
	if(window_Wt < 767 && window_Ht > 370){
		var _originalSize = $(window).width() + $(window).height();
		$(".login_section .login_btn").css("position","absolute");
		$(".mobile_version .mail_compose_section .btn_section").css("position","absolute");
		$(window).resize(function(){
			if($(window).width() + $(window).height() != _originalSize){
				$(".login_section .login_btn").css("position","static");  
				$(".mobile_version .mail_compose_section .btn_section").css("position","static"); 
			}else{
				$(".login_section .login_btn").css("position","absolute");  
				$(".mobile_version .mail_compose_section .btn_section").css("position","absolute");  
			}
		});
	}
	
	if(window_Wt < 640 && window_Ht > 370){
		$(".login_section").css("padding-top","100px");
	}
	
	var title_Ht = $(".mobile_version .mail_compose_section .title_bar").height();
	var btnSection_Ht = $(".mobile_version .mail_compose_section .btn_section").height();
	var chat_Ht = window_Ht -(title_Ht+btnSection_Ht+18);
	if(window_Wt < 767 && window_Ht >= 320){
		$(".mobile_version .chat_room").css("height",chat_Ht);
	}
	
	var title_Ht1 = $(".mail_compose_section .title_bar").height();
	var btnSection_Ht1 = $(".mail_compose_section .btn_section").height();
	var mail_box_Ht1 = $(".mail_compose_section").height();
	var chat_Ht1 = mail_box_Ht1 -(title_Ht1+btnSection_Ht1+18);
	if(window_Ht > 767){
		$(".mail_compose_section .chat_room").css("height",chat_Ht1);
	}
	
	/*$(".form_block input[type='text']").focus(function(){
		$(this).prev().css("color","red");
		$(".update_btn").css("background","red");
	});
	$(".form_block input[type='text']").blur(function(){
		$(this).prev().css("color","#4a4a4a");
		$(".update_btn").css("background","#d8d8d8");
	}); */
	
	
    $('a[data-collapse="child"]').on('click', function(evt){
		var currtext=$(this).find('.material-icons').text();
		var eleId=$(this).attr('href');
		$( 'a[data-collapse="child"]').each( function( index, element ){
			$(this).children('.material-icons').text('expand_more'); 
        });
		
		if(currtext=="expand_less"){
			$(this).find('.material-icons').text('expand_more'); 
			
		}else{
			$(this).find('.material-icons').text('expand_less'); 
		}
		addCollapeClass(eleId);
    });
	
	function addCollapeClass(reqEle){
		var eleArr=['#nested-collapseSeven','#nested-collapseEight','#nested-collapseNine'];
		for(var index in eleArr){
			if(eleArr[index]!=reqEle){
				if($(eleArr[index]).hasClass('in')){
					$(eleArr[index]).removeClass('in');
				}
			}
		}
	}
	
	
	
//	panel-collapse collapse
    
    $('a[data-collapse="parent"]').on('click', function(){

           var isShown;
         if($(this).attr('aria-expanded')==='true'){
            isShown=true;
         }else{
            isShown=false;
         }
         isShown =! isShown;
       $(this).attr('aria-expanded',isShown);
	   
        if($(this).attr('aria-expanded')==='true'){
			if($(this).hasClass('edit-course')){
				$(this).next().children('.material-icons').text('expand_less');       
			}else{
				$(this).children('.material-icons').text('expand_less');       
			}
        }else{
			if($(this).hasClass('edit-course')){
				$(this).next().children('.material-icons').text('expand_more');       
			}else{
				$(this).children('.material-icons').text('expand_more'); 
			}
        }
         
    });
	
	
    $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
            }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
    });

    
    $("#idfileUpload").click(function(){
       $(".uploadFile").click();
    });
       $("#idfileUpload-mobile").click(function(){
       $(".uploadFile1").click();
    });
    $("#uploadTrigger").click(function(){
	   $("#matrix_browse").click();
	});
    $("#add_file").click(function(){
       $("#fileBtn").click();
    });

    /*$(".profile_image").click(function(){
            $(".browse_btn").click();
    }); */
    $("#user_profile_image").click(function(){
        $("#userprofile_userImage").click();
    });

    

    $('#onboard1 .submit_btn').click(function() {  
            $('#onboard1').hide();
    });
    $('.date_field').each(function(){
		$(this).datetimepicker({
			controlType: 'select',
			oneLine: true,
			timeFormat: 'hh:mm tt',
			dateFormat: 'dd/mm/yy',
            minDate: 'today'
		});
    });
	
	$('.log_date_field').each(function(){
        $(this).datetimepicker({
            controlType: 'select',
            oneLine: true,
            timeFormat: 'hh:mm tt',
            dateFormat: 'dd/mm/yy'
        });
    });

    $("#ui-datepicker-div").click(function (event) {
            event.preventDefault();
            event.stopPropagation();
    });
    $(".profile_popup .form-group span").click(function(){
            $(this).prev().removeAttr('readonly').css({cursor: 'text',color: '#000'}).focus();
    });
    
    $("#add_file_txt").click(function(){
        $("#file").click();
    });

    $("body").on('click', '', function(){
        $("#fileupload").click();
    });
         
    $("#take_photo span").click(function(){
        $("#take_photo_btn").click();
    });
	
	var _originalSize = $(window).width() + $(window).height()
	$(window).resize(function(){
		if($(window).width() + $(window).height() != _originalSize){
			//console.log("keyboard show up");
			$(".main_container .mobile_version_block .section.change_pwd_section .content,.main_container .mobile_version_block .section.change_pwd_section .btn").css("position","static"); 
		}else{
			//console.log("keyboard closed");
			$(".main_container .mobile_version_block .section.change_pwd_section .content,.main_container .mobile_version_block .section.change_pwd_section .btn").css("position","absolute"); 
		}
	});

});
$(window).resize(function(){    
	var window_Ht = $(window).height();
	var window_Wt = $(window).width();
	var header_Ht = $("header").height();
	var footer_Ht = $(".mobi-profile").height();
	var mobile_view_Ht = window_Ht - header_Ht - footer_Ht;
	var mobile_view_Ht1 = window_Ht - footer_Ht;
	
	$(".mobile_version").css("position","relative");
	$(".mobile_version,.login_page").css("height",window_Ht);
	$(".message_section .mobile_version,.mobile_version .mail_secion,.mobile_version .new_message_section").css("height",mobile_view_Ht);
	
	if(window_Wt >= 320 && window_Ht < 767){
		$('.main_container,.step_list').css("height",window_Ht);
		$('.body_section,.portfolio-container').css("height",mobile_view_Ht);
		$('.candidate-details .body_section').css("height",mobile_view_Ht1);
		$(".change_link").click(function(){
			$(".body_section.candidate_profile").css("height",window_Ht);
		});
		$(".clear_pswd_div").click(function(){
			$(".body_section.candidate_profile").css("height",mobile_view_Ht);
		});
	}

	var newTitle_Ht = $(".mobile_version .new_message_section .title_bar").height();
	var inputField_Ht = $(".input_section").outerHeight() * 2;
	var sendBtnSection_Ht = $(".mobile_version .new_message_section .btn_section").height();
	var textarea_ht = window_Ht - (newTitle_Ht + inputField_Ht + sendBtnSection_Ht);
	$(".mobile_version .new_msg_section textarea").css("height",textarea_ht);
	
	if(window_Wt < 530 && window_Ht >= 480){
		$("#profile1 .modal-body").css("height",window_Ht);
		$("#profile1 .submit_btn").css("position","absolute");
	}
	
	/*if(window_Wt < 767 && window_Ht > 370){
		$(".login_section .login_btn").css("position","absolute");
	}*/
	if(window_Wt < 767 && window_Ht > 370){
		var _originalSize = $(window).width() + $(window).height();
		$(".login_section .login_btn").css("position","absolute");
		$(".mobile_version .mail_compose_section .btn_section").css("position","absolute");
		$(window).resize(function(){
			if($(window).width() + $(window).height() != _originalSize){
				$(".login_section .login_btn").css("position","static");  
				$(".mobile_version .mail_compose_section .btn_section").css("position","static"); 
			}else{
				$(".login_section .login_btn").css("position","absolute");  
				$(".mobile_version .mail_compose_section .btn_section").css("position","absolute");  
			}
		});
	}
	
	var title_Ht = $(".mobile_version .mail_compose_section .title_bar").height();
	var btnSection_Ht = $(".mobile_version .mail_compose_section .btn_section").height();
	var chat_Ht = window_Ht -(title_Ht+btnSection_Ht+18);
	if(window_Wt < 767 && window_Ht >= 320){
		$(".mobile_version .chat_room").css("height",chat_Ht);
	}
});

/* for showing the dropdown up and down of the respective field based on the page scroll */
function determineDropDirection(){
	$(".dropdown-menu").each( function(){
		$(this).css({
		  visibility: "hidden",
		  display: "block"
		});
		
		$(this).parent().removeClass("dropup");
		
		if ($(this).offset().top + $(this).outerHeight() > $(window).innerHeight() + $(window).scrollTop()){
		  $(this).parent().addClass("dropup");
		}
		
		$(this).removeAttr("style");
	});
}

determineDropDirection();
$(window).scroll(determineDropDirection);


if($('#add_file_txt').length > 0 ) {
    document.getElementById('add_file_txt').addEventListener("drop", function(event) {
        event.preventDefault();
             filesSelectedToUpload(event);
    });
    document.getElementById('add_file_txt').addEventListener("dragover", function(event) {
        event.preventDefault();
    });
}
var modalVerticalCenterClass = ".modal";
function centerModals($element) {
    var $modals;
    if ($element.length) {
        $modals = $element;
    } else {
        $modals = $(modalVerticalCenterClass + ':visible');
    }
    $modals.each( function(i) {
        var $clone = $(this).clone().css('display', 'block').appendTo('body');
		var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
		top = top > 0 ? top : 0;
        $clone.remove();
		$(this).find('.modal-content').css("margin-top", top);
    });
	
}
$(modalVerticalCenterClass).on('show.bs.modal', function(e) {
      modEle=$(this);
    centerModals($(this));
});
$(window).on('resize', centerModals);
$('#myModal,#profile2,#confirm_popup').modal({backdrop: 'static', keyboard: false,show:false});

/* show the current input when focus for mobile */
/* $('#userprofile').on('focusin', 'input[type="text"]', function(event) {
	if(navigator.userAgent.indexOf('Android') > -1){
		var scroll = $(this).offset();
		window.scrollTo(0, scroll);
	}
}); */