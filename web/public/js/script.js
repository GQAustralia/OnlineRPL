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
    var window_Ht = $(window).height();
    var window_Wt = $(window).width();
    $(".mobile_version,.login_page").css("height",window_Ht);

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

    $(".profile_image").click(function(){
            $(".browse_btn").click();
    });
    var textarea_ht = window_Ht - 135;
    $(".mobile_version .new_msg_section textarea").css("height",textarea_ht);

    if(window_Wt < 530 && window_Ht >= 480){
            $("#profile1 .modal-body").css("height",window_Ht);
            $("#profile1 .submit_btn").css("position","absolute");
    }

    if(window_Wt < 767 && window_Ht > 370){
            $(".login_section .login_btn").css("position","absolute");
    }

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
});
$(window).resize(function(){
	var window_Ht = $(window).height();
	var window_Wt = $(window).width();
	$(".mobile_version,.login_page").css("height",window_Ht);
	
	var textarea_ht = window_Ht - 135;
	$(".mobile_version .new_msg_section textarea").css("height",textarea_ht);
	
	if(window_Wt < 530 && window_Ht >= 480){
		$("#profile1 .modal-body").css("height",window_Ht);
		$("#profile1 .submit_btn").css("position","absolute");
	}
	
	if(window_Wt < 767 && window_Ht > 370){
		$(".login_section .login_btn").css("position","absolute");
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
