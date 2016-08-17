$(document).ready(function(){
    /* header menu js starts*/
    
    $(".profile").on("click", function(){
       $(this).children('ul').toggleClass("show hide");
    });
    
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
	
	var mobile_view_Ht = window_Ht - header_Ht;
	$(".mobile_version,.login_page,.mobile_version .mail_secion").css("height",mobile_view_Ht);

	
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
		}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
	});
	
	var newTitle_Ht = $(".mobile_version .new_message_section .title_bar").height();
	var inputField_Ht = $(".input_section").height() * 2;
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
		$(window).resize(function(){
			if($(window).width() + $(window).height() != _originalSize){
				alert("keyboard show up");
				$(".login_section .login_btn").css("position","static");  
			}else{
				alert("keyboard closed");
				$(".login_section .login_btn").css("position","absolute");  
			}
		});
	}
	
	if(window_Wt < 640 && window_Ht > 370){
		$(".login_section").css("padding-top","100px");
	}
	
	var title_Ht = $(".mobile_version .mail_compose_section .title_bar").height();
	var btnSection_Ht = $(".mobile_version .mail_compose_section .btn_section").height();
	var chat_Ht = window_Ht -(title_Ht+btnSection_Ht);
	if(window_Wt < 767 && window_Ht >= 320){
		$(".mobile_version .chat_room").css("height",chat_Ht);
	}
	
	$(".form_block input").focus(function(){
		$(this).prev().css("color","red");
		$(".update_btn").css("background","red");
	});
	$(".form_block input").blur(function(){
		$(this).prev().css("color","#4a4a4a");
		$(".update_btn").css("background","#d8d8d8");
	});
	
    $('a[data-collapse="child"]').on('click', function(){
        var nestedCollapse;
        $( 'a[data-collapse="child"]').each( function( index, element ){
			$(this).children('.material-icons').text('expand_more'); 
        });

        if($(this).attr('aria-expanded')==='true'){
			$(this).children('.material-icons').text('expand_more'); 
        }else{
           $(this).children('.material-icons').text('expand_less');       
        }
    });
    
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
           $(this).children('.material-icons').text('expand_less');       
        }else{
           $(this).children('.material-icons').text('expand_more'); 
        }
         
    });
    $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".keyboard_arrow_down").removeClass("keyboard_arrow_down").addClass("keyboard_arrow_right");
            }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".keyboard_arrow_right").removeClass("keyboard_arrow_right").addClass("keyboard_arrow_down");
    });

    $(".uploadTrigger").click(function(){
       $(".uploadFile").click();
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

    $(".form_block input").focus(function(){
            $(this).prev().css("color","red");
            $(".update_btn").css("background","red");
    });
    $(".form_block input").blur(function(){
            $(this).prev().css("color","#4a4a4a");
            $(".update_btn").css("background","#d8d8d8");
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

    $("#ui-datepicker-div").click(function (event) {
            event.stopPropagation();
    });
    $(".profile_popup .form-group span").click(function(){
            $(this).prev().removeAttr('readonly').focus();
    });
    
    $("#add_file_txt").click(function(){
	
        $("#file").click();
     });

	$("body").on('click', '', function(){
		$("#fileupload").click();
	 });

});
$(window).resize(function(){
	var window_Ht = $(window).height();
	var window_Wt = $(window).width();
	var header_Ht = $("header").height();
	var mobile_view_Ht = window_Ht - header_Ht;
	
	$(".mobile_version,.login_page,.mobile_version .mail_secion").css("height",mobile_view_Ht);

	var newTitle_Ht = $(".mobile_version .new_message_section .title_bar").height();
	var inputField_Ht = $(".input_section").height() * 2;
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
		$(window).resize(function(){
			if($(window).width() + $(window).height() != _originalSize){
				alert("keyboard show up");
				$(".login_section .login_btn").css("position","static");  
			}else{
				alert("keyboard closed");
				$(".login_section .login_btn").css("position","absolute");  
			}
		});
	}
	
	var title_Ht = $(".mobile_version .mail_compose_section .title_bar").height();
	var btnSection_Ht = $(".mobile_version .mail_compose_section .btn_section").height();
	var chat_Ht = window_Ht -(title_Ht+btnSection_Ht);
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