var qual_id;
var fileid;
var filetype;
var unitId;
var courseCode;
var userId;
var unit;
var reminderid;
var reminderflag;
var otherfiles;
var setnotesid;
var deluserId;
var delUserRole;
$(function() {
    var $ppc = $('.progress-pie-chart'),
            percent = parseInt($ppc.data('percent')),
            deg = 360 * percent / 100;
    if (percent > 50) {
        $ppc.addClass('gt-50');
    }
    $('.ppc-progress-fill').css('transform', 'rotate(' + deg + 'deg)');
    $('.ppc-percents span').html(percent + '%');
    if (percent == 100) {
        $(".progress-pie-chart").css("background-color", "#86b332");
        $(".gq-dashboard-points-in-percent").css("color", "#86b332");
    }

    $("#eqclose-cancel").click(function() {
        $("#eqclose").trigger("click");
    });

    $(".evTitleData").click(function() {
        var evtitle = $(this).attr("data-evtitle");
        var evid = $(this).attr("data-evid");
        $("#editEvidenceModelinput").val(evtitle);
        $("#editEvId").val(evid);
    });

    $(".editEvidenceSave").click(function() {
        var title = $("#editEvidenceModelinput").val();
        var id = $("#editEvId").val();
        $(".edittitle_loader").show();
        $.ajax({
            type: "POST",
            url: "editEvidenceTitle",
            cache: false,
            data: {title: title, id: id},
            success: function(result) {
                if (result == "success")
                {
                    if (title.length > 20) {
                       title = title.substring(0, 20)+'...';
                    }
                    $("#eqclose").trigger("click");
                    $("#editEvidenceModelinput").val(title);
                    $("#ev-" + id).attr("data-evtitle", title);
                    $("#evd-title-" + id).html(title);
                    $(".edittitle_loader").hide();
                }
            }
        });
    });
    
   $("body").on("click", ".unit-emailcon", function() {
        var id = $(this).parent().attr('id');
        var userId = $(this).attr("userId");
        var courseCode = $(this).attr("courseCode");
        $('body #facilitatorApplicantMessages').html('');
        $('body #facilitatorApplicantMessages').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    
        $.ajax({
            type: "POST",
            url: base_url + "facilitatorApplicant",
            cache: false,
            data: {unitId: id, userId: userId, courseCode : courseCode},
            success: function(result) {
                $("body #facilitatorApplicantMessages").html(result);
            }
        });
    });
    
    // to send the notifications and mail when the status is changed
    $("body").on("change", "#courseStatus", function() {
        var userId = $("#csUserId").val();
        var courseCode = $("#csCourseCode").val();
        var courseStatus = $("#courseStatus").val();
        $("body #status-message").show();
        $("body #status-message").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><img src="' + base_url + 'public/images/loading.gif"></div>');
        if (courseStatus !== "") {
            $.ajax({
                type: "POST",
                url: base_url + "updateCourseStatus",
                data: {courseStatus: courseStatus, courseCode: courseCode, userId: userId},
                success: function(responseText) {
                    var result = jQuery.parseJSON(responseText);
                    if(result.type == 'Error' ) {
                        $("body #status-message").html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2>'+ result.msg+'</h2></div>');
                        window.scrollTo(0, 0);
                    } else if (result.type == 'Success') {
                        $("body #status-message").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span> '+ result.msg+'</span></div>'); 
                        window.scrollTo(0, 0);
                    }   
                    if(result.code == '1'){
                      $("#currentCourseStatus").val(courseStatus);  
                       if(courseStatus == '2'){ 
                            $( "body #submittoassessor").hide( "slow"); 
                       }
                       if(courseStatus == '12'){ 
                            $( "body .competency-call").hide( "slow"); 
                       }
                    } else if(result.code != '5') {
                          if ( $('#courseStatus option[value="' + $("#currentCourseStatus").val() + '"]').length > 0 ) {  
                              $("#courseStatus").val($("#currentCourseStatus").val());
                              $("#selectcourseStatus").html($('#courseStatus option[value="' + $("#currentCourseStatus").val() + '"]').html());
                          } else {
                              $("#courseStatus").val($("#courseStatus option:first").val());
                              $("#selectcourseStatus").html($("#courseStatus option:first").html());                          
                          }
                    }
                }
            });
      } else {
          $("body #status-message").html('<div class="gq-id-files-upload-error-text alert alert-danger"><strong> Please select status</strong></div>');
          window.scrollTo(0, 0);
      }
    });
});

$("#view_terms").click(function() {
    $.ajax({url: "updateCondition", success: function(result) {
        }});
});

$(".modalClass").click(function() {
    qual_id = this.id;
});
$("#qclose").click(function() {
    if (qual_id != '' && typeof qual_id !== 'undefined') {
        $(location).attr('href', base_url + 'qualificationDetails/' + qual_id);
    }
});

$(".checkmark-icon").click(function() {
    unitId = $(this).attr("unit_id");
    courseCode = $(this).attr("course_code");
    userId = $(this).attr("user_id");
});

$(".changeUnitStatus").click(function() {   
    $(".qual_status_loader").show();
    var count = $('input[name="chk-val-'+courseCode+'[]"]:checked').length;
    
    var countElectiveUnits = $('#chkboxCount').val();
    var countremain = parseInt(countElectiveUnits) - parseInt(count);
    $.ajax({
        type: "POST",
        url: base_url + "updateUnitElective",
        data: {unitId: unitId, courseCode: courseCode, userId: userId},
        success: function(result) {          
            var c = $("#label_"+unitId).hasClass("open");
            if (c == true) {
                $("#label_"+unitId).trigger("click");
            }
            var label = $("#label_" + unitId).attr("temp");
            if (result == '0') {
                //$("#span_" + unitId).removeClass("radioUnChecked");
                 $("#span_" + unitId).prop('checked', false);
                 $("#sub_" + unitId).html('');
                
            } else {
                $("#span_" + unitId).prop('checked', true);
             //   $("#span_" + unitId).addClass("radioUnChecked");
                
            } 
            if( count >= countElectiveUnits)
            {              
               
		$("#course-btn-container-"+courseCode).removeClass('course-edit hide').addClass('course-edit show');
			$('#btn-done-'+courseCode).removeClass('show').addClass('hide');
                $("#nested-collapseSTR-"+courseCode).removeClass('panel-collapse collapse').addClass("panel-collapse collapse in");
               //$('#edit_'+courseCode).css("margin-right","10px");
               $("#course_toggle_"+courseCode).addClass('show');
               //$('#course_toggle_'+courseCode).addClass('hide');
               $("#toggle_edit_"+courseCode).removeClass('show').addClass('hide');
                
                 $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').each(function(){
                        $(this).removeClass('hide');
                        $(this).addClass('edit-show');
             });
                 
                 $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').prev().each(function(){
                      $(this).addClass('hide');
                        $(this).removeClass('edit-show');
                 });
               
                  $("#strip_"+courseCode).css("background-color", "#E01010");               
                    $("#edit_"+courseCode).removeClass('hide');
                 $("#edit_"+courseCode).addClass('show');
                 $("#spanremain").html('<strong> - '+countremain+' REMAINING </strong>');
            }
            else
            {  
                
                $("#course_toggle_"+courseCode).removeClass('hide').addClass('show');
                 $("#toggle_edit_"+courseCode).removeClass('hide');
                 
                  // $("#course_toggle_"+courseCode).addClass('show');
                 $("#toggle_edit_"+courseCode).css('display','inline !important')
                 
                 $("#course_toggle_"+courseCode).show();
                 $("#toggle_edit_"+courseCode).show();
                 $("#course-btn-container-"+courseCode).removeClass('course-edit show').addClass('course-edit hide');
                 
                 
		//$('btn-done-'+courseCode).hide();		 
                $("#nested-collapseSTR-"+courseCode).removeClass('panel-collapse collapse in').addClass("panel-collapse collapse in");
                $("#strip_"+courseCode).removeAttr("style");
               
                $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').each(function(){
                        $(this).removeClass('edit-show');
                        $(this).addClass('hide');
             });
                 
                 $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').prev().each(function(){
                      $(this).addClass('edit-show');
                        $(this).removeClass('hide');
                 });
                if(countremain < countElectiveUnits) {
                     $("#spanremain").html('<strong> - '+countremain+' REMAINING </strong>');
                }else {
                    if(count == '0') {
                        $("#spanremain").html('- Choose '+countElectiveUnits);
                    }
                }
            }
            $(".qual_status_loader").hide();
            $("#qeclose").trigger("click");
        }
    });
});

$(".fromBottom").click(function() {
    unit = $(this).attr("unitid");
    courseCode = $(this).attr("course_code");
    $('#file_hid_unit').val(unit);
    $('#file_hid_course').val(courseCode);
    $('.gq-dashboard-tabs').show();
    $('#gq-dashboard-tabs-success').hide();
    $('#file_save').show();
    //$('#frmAddEvidence')[0].reset();
    //$('#frmSelectEvidence')[0].reset();

    var c = $('#select-from-evidence-tab').hasClass("active");
    if (c == true) {
        $('#add-evidence-tab').addClass('active');
        $('#div_add_evidence').addClass('active');

        $('#select-from-evidence-tab').removeClass('active');
        $('#div_existing_evidence').removeClass('active');
    }
});

/*$("#frmSelectEvidence").submit(function() {
    alert('submit');
    $('#select_hid_unit').val(unit);
    $('#select_hid_course').val(courseCode);
});*/

$(".deleteEvidence").click(function() {
    $('.deleteevidence_loader').show();
    $("#evidence_msg").show();
    var fid = fileid;
    var ftype = filetype;
    $.ajax({
        type: "POST",
        url: base_url + "deleteEvidenceFile",
        data: {fid: fid, ftype: ftype},
        success: function(result) {
            $('#evd_' + fid).hide();
            $("#qclose").trigger("click");
            $('#confirm_popup').modal('hide');            
            $("#evidence_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Evidence File deleted successfully!</span></div>');
            $('.deleteevidence_loader').hide();
            $('#evidencefiles tr#'+fid).hide();
            $('#fileId'+fid).hide();
			$('.body_section').scrollTop(0);
            oTable.row('#'+fid).remove().draw();            
            setFacetingFilterCount(oTable, 'filter');    
        }
    });
});

$(".deleteIdFiles").click(function() {
    var fid = fileid;    
    var ftype = filetype;
    var url = (otherfiles) ? "deleteOtherFiles" : "deleteIdFiles";
    $("#ajax-loading-delete-assessor-file").show();    
    $.ajax({
        type: "POST",
        url: base_url + url,
        data: {fid: fid, ftype: ftype},
        success: function(result) {
            $("#del_"+fid).hide();
            $("#ajax-loading-delete-assessor-file").hide();
            $("#idfiles_msg").show();
            $('#idfiles_' + fid).hide();
            $("#fclose").trigger("click");
            
            $("#idfiles_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>File deleted successfully!</span></div>');
			$("#profile_suc_msg2").hide();
            if(url == 'deleteIdFiles')
                    window.location.href = base_url+'userprofile';
             else 
               {
                        window.location.reload(false);
                        //$("#profile2").load(location.href + " #profile2>*", "");
                        $("#idfiles_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>File deleted successfully!</span></div>');
                        $('#profile2').modal('show');  
                        
                }
       } 
    });
});
$('#file_file').on('change', function(){
    $('#file_save').trigger('click');
});
if($('#frmAddEvidence').length) 
{
    $("#frmAddEvidence").ajaxForm({
        beforeSubmit: function() {
            $('#file_save').hide();
            $('.uploadevidence_loader').show();
        },
        success: function(responseText, statusText, xhr, $form) {
            $('.gq-dashboard-tabs').hide();
            $('.uploadevidence_loader').hide();
            if (responseText == 'yes') {
                $('#gq-dashboard-tabs-error').show();
                $('#gq-dashboard-tabs-error').html('<h2>File size more than 10MB cannot be uploaded!</h2>');
            } else {
                $('#gq-dashboard-tabs-success').show();
                $('#sp_'+responseText).show();
                $('#gq-dashboard-tabs-success').html('<h2> Evidence uploaded successfully!</h2>');
            }
            setTimeout(function(){jQuery("#evd_close").trigger('click');},3000);
        },
        resetForm: true
    });
}
if($('#frmSelectEvidence').length) 
{
    $("#frmSelectEvidence").ajaxForm({
        beforeSubmit: function() {
           
        },
        success: function(responseText) {
            $('.gq-dashboard-tabs').hide();
            $('.uploadevidence_loader').hide();
            $('#gq-dashboard-tabs-success').show();
            if (responseText){            
                $('#sp_'+responseText).show();
                $('#gq-dashboard-tabs-success').html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Existing Evidence uploaded successfully!</span></div>');
            }
            setTimeout(function(){jQuery("#evd_close").trigger('click');},3000);
        },
        resetForm: true
    });
}
$("body").on('click', '#download_profile', function() {
    userId = $(this).attr("userid");
    courseCode = $(this).attr("course_code");
    window.open(base_url + "downloadFiles/" + courseCode + "/" + userId);
    window.open(base_url + "zipFiles/" + courseCode + "/" + userId);
});
$("body").on('click', '#signoff_sheet', function() {
    userId = $(this).attr("userid");
    courseCode = $(this).attr("course_code");
    window.open(base_url + "signOffSheet/" + courseCode + "/" + userId);
});
$("#download_matrix").click(function() {
    window.open(base_url + "downloadMatrix");
});

$("#download_assessor_profile").click(function() {
    userId = $(this).attr("userid");
    window.open(base_url + "downloadAssessorProfile/" + userId);
});

$(".todo-list").on('click', '.todomodalClass', function(){    
    $('#confirm_popup').find('.updateTodo').prop('disabled', false);
    reminderid = $(this).attr('id');
});
$("#todo-cancel").click(function() {
    $("#todoclose").trigger("click");
});
/* dashboard update todo list functionality starts */
$("body").on('click', '.updateTodo', function() {
    $(this).prop('disabled', true);
    var rmid = reminderid;
    flag = "1";
    var completedItem = 1;
    var percentage = '';
    var currentTodoItem = $('#'+rmid).parent().parent();
    var statusTxt = $('.status-txt');
    var thumbTxt = $('.thumb-txt');
    var viewContent = '';
    var thumbTxtContent = 'thumb_up';

    $.ajax({
        type: "POST",
        url: "updateTodo",
        data: {rmid: rmid, flag: flag},
        success: function(result) {
            if (result == "success")
            {
                $('#confirm_popup').modal('hide');
                completedItem = parseInt(completedItem) + parseInt($('.progress-bar').attr('data-citem'));
                totalItem = parseInt($('.progress-bar').attr('data-titem'));
                percentage = (completedItem/totalItem)*100;
                currentTodoItem.addClass('disable').find('span.content').removeClass('bold');
                currentTodoItem.addClass('disable').find('input[type="checkbox"]').removeClass('updateTodo').attr('data-status', '0').prop('disabled', 'disabled');
                $('.completed-list').prepend(currentTodoItem);
                $('.completed-list').find('.emptyCompletedTodo').hide();
                if($('.todo-list li').length == '1')
                    $('.todo-list li.emptyPendingTodo').removeClass('hide');
                $('.progress-bar').css('width', percentage+"%").attr('data-citem', completedItem);
                $('.todo-percent').html(Math.ceil(percentage));

                if (Math.ceil(percentage) >= '90' && Math.ceil(percentage) < '100')
                {
                    viewContent =  'ALMOST DONE';
                } else if(Math.ceil(percentage) >= '100') {
                    viewContent =  'NICE WORK';
                } else {
                    viewContent =  '';
                    thumbTxtContent =  '';
                }

                if(statusTxt.text().trim().length == '0' || statusTxt.text().trim() != viewContent )
                    statusTxt.html(viewContent);
                    thumbTxt.html(thumbTxtContent);

                $('#err_msg').show();
                $("#err_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Moved to completed today successfully</span></div>').delay(3000).fadeOut(100);
				$('.body_section').scrollTop(0);
            }
        }
    });
});
$('.cancelTodo').click(function(){
    $('#'+reminderid).prop('checked', false);
    $('.closeModal').trigger('click');
    return false;
});
/* dashboard update todo list functionality ends */
function validateExisting()
{
    var efile = $(".check_evidence:checkbox:checked").length;
    if (efile <= 0 || efile == '' || typeof efile === 'undefined') {
        //alert('Please select atleast one Existing Evidence!');
        $('#gq-dashboard-tabs-success').hide();
        $('#gq-dashboard-tabs-error').show();
        $('#gq-dashboard-tabs-error').html('<h2 style="text-align: center; width: 100%; font-size: 14px; color: red; padding: 10px;">Please select atleast one Existing Evidence!</h2>');

        return false;
    } else {
        sumitFormEvidence();
    }
    return false;
}

$("#userprofile_userImage").change(function() {
    $("#ajax-loading-icon").show();
    var userId = $('#hdn-userId').val();
    var userType = $('#hdn-type').val();
    var fileName = $(this).val();
    var Extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
    if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {
        
        var file_data = $('#userprofile_userImage').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        profileImageUpload();
       
    }
    else
    {
		$("#profile_suc_msg2").hide();
        $("#ajax-profile-error").show();
        $("#ajax-profile-error").html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2>Please upload valid image</h2></div>');
        //alert("Please upload valid image");
        return false;
    }
});

$(".unit-evidence-id").click(function() {
    $(".gq-extra-space").show();    
    $('#unit-evidence-tab').html('');
    $('#unit-evidence-tab').html($('#unit-evidence-tab2').html());
    $("#myTab2 li").removeClass('active');
    var newunit = $(this).attr("unitid");
    $(".custom-close").attr('id',newunit);
    var c = $("#label_"+newunit).hasClass("open");
    if (c == false) {
        $("#label_"+newunit).trigger("click");
    }    
    $('html,body').animate({scrollTop: $('#div_'+newunit).offset().top}, 1000);
    userId = $(this).attr("userid");
    delStatus = $(this).attr("del-status");
    course_code = $(this).attr("course_code");
    course_name = $(this).attr("course_name");
    unittitle = $(this).attr("unittitle");
    $.ajax({
        type: "POST",
        url: base_url + "getUnitEvidences",
        data: {unit: newunit, userId: userId, delStatus: delStatus, unittitle: unittitle, course_code: course_code, course_name: course_name},
        success: function(result) {
            $('#unit-evidence-tab').html(result);
        }
    });
});



$(".show_path").change(function() {
    var fileName = $(this).val().replace(/C:\\fakepath\\/i, '');
    if (fileName)
        $(this).parent().parent().parent().next().html('<div class="col-lg2 col-md-2 col-sm-3 col-xs-12"><div class="gq-id-files-upload-txt">' + fileName + '</div></div>');
    else
        $(this).parent().parent().parent().next().html('');
    //$(this).parent().parent().next().("#idfiletype_image").html('<div class="col-lg2 col-md-2 col-sm-3 col-xs-12"><div class="gq-id-files-upload-txt">'+fileName+'</div></div>');
});

$("#qclose-cancel").click(function() {
    $("#qclose").trigger("click");
});

$("#fclose-cancel").click(function() {
    $("#fclose").trigger("click");
});

$("#qeclose-cancel").click(function() {
    $("#qeclose").trigger("click");
});


$("body").on("click", ".viewModalClass", function() {
    fileid = $(this).attr('fileid');
    filetype = $(this).attr('filetype');
    otherfiles = $(this).attr('otherfiles');
});

$(".openIcon").click(function() {
    var c = $(this).hasClass("open");
    if (c == false) {
        $(this).parent().parent().addClass("active");
        $(this).addClass("open");
    } else {
        $(this).parent().parent().removeClass("active");
        $(this).removeClass("open");
    }
});
if($('#Id_files').length) 
{
    $("#Id_files").ajaxForm({
        beforeSubmit: function() {
            $('#ID_load').show();
        },
        success: function(responseText, statusText, xhr, $form) {
            $('#ID_load').prev().html('');
            $('#ID_load').hide();
            if (responseText) {
                $("#idfiles_msg").show();
                var result = jQuery.parseJSON(responseText);
                var name = result.name.split('.');
                var ftype = result.type.split('.'); 
                $("#idfiles_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>File added successfully!</span></div>');
                window.location.href = base_url+'userprofile';
            }
        },
        resetForm: true
    });
}
if($('#resumeUpload').length) 
{
    $("#resumeUpload").ajaxForm({
        beforeSubmit: function() {
            $('#resume_load').show();
        },
        success: function(responseText, statusText, xhr, $form) {
            $('#resume_load').prev().html('');
            $('#resume_load').hide();
            if (responseText) {
                $('#resume_msg').css("display", "block");
                var result = jQuery.parseJSON(responseText);
                var name = result.name.split('.');
                var html = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" id="idfiles_' + result.id + '"><div class="gq-dashboard-courses-detail"><span class="gq-dashboard-points-icon">\n\
                                <a class="modalClass viewModalClass" data-toggle="modal" data-target="#myModal" otherfiles="others" fileid="' + result.id + '" filetype="' + result.type + '">\n\
                                    <div class="gq-del-evidence"></div></a>\n\
                                <div class="tooltip-home top">\n\
                                    <div class="tooltip-arrow"></div>\n\
                                    <span class="">Delete ID File</span>\n\
                                </div>\n\
                            </span>\n\
                            <a href = "' + amazon_link + result.path + '" class="fancybox fancybox.iframe"><div class="gq-id-files-content-icon-wrap gq-id-files-content-doc-icon"></div></a><div class="gq-id-files-content-row-wrap"><div class="gq-id-files-content-row"><label>Title</label><span>' + name[0] + '</span></div><div class="gq-id-files-content-row"><label>Added on</label><span>' + result.date + '</span></div></div></div></div>';
                if ($('#resume_no_files').html() === 'No resumes found') {
                    $('.resume_files').html(html);
                } else {
                    $('.resume_files').append(html);
                }
                $('#resume_msg').css("display", "block");
            }
        },
        resetForm: true
    });
}
if($('#qualificationUpload').length) 
{
    $("#qualificationUpload").ajaxForm({
        beforeSubmit: function() {
            $('#qualification_load').show();
        },
        success: function(responseText, statusText, xhr, $form) {
            $('#resume_msg').css("display", "block");
            $('#qualification_load').prev().html('');
            $('#qualification_load').hide();
            if (responseText) {
                var result = jQuery.parseJSON(responseText);
                var name = result.name.split('.');
                var html = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" id="idfiles_' + result.id + '"><div class="gq-dashboard-courses-detail"><span class="gq-dashboard-points-icon">\n\
                                <a class="modalClass viewModalClass" data-toggle="modal" data-target="#myModal" otherfiles="others" fileid="' + result.id + '" filetype="' + result.type + '">\n\
                                    <div class="gq-del-evidence"></div></a>\n\
                                <div class="tooltip-home top">\n\
                                    <div class="tooltip-arrow"></div>\n\
                                    <span class="">Delete ID File</span>\n\
                                </div>\n\
                            </span>\n\
                            <a href = "' + amazon_link + result.path + '" class="fancybox fancybox.iframe"><div class="gq-id-files-content-icon-wrap gq-id-files-content-doc-icon"></div></a><div class="gq-id-files-content-row-wrap"><div class="gq-id-files-content-row"><label>Title</label><span>' + name[0] + '</span></div><div class="gq-id-files-content-row"><label>Added on</label><span>' + result.date + '</span></div></div></div></div>';
                if ($('#qualification_no_files').html() === 'No qualifications found') {
                    $('.qualification_files').html(html);
                } else {
                    $('.qualification_files').append(html);
                }
                $('#resume_msg').css("display", "block");
            }
        },
        resetForm: true
    });
}
if($('#referenceUpload').length) 
{
    $("#referenceUpload").ajaxForm({
        beforeSubmit: function() {
            $('#reference_load').show();
        },
        success: function(responseText, statusText, xhr, $form) {
            $('#resume_msg').css("display", "block");
            $('#reference_load').prev().html('');
            $('#reference_load').hide();
            if (responseText) {
                var result = jQuery.parseJSON(responseText);
                var name = result.name.split('.');
                var html = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" id="idfiles_' + result.id + '"><div class="gq-dashboard-courses-detail"><span class="gq-dashboard-points-icon">\n\
                                <a class="modalClass viewModalClass" data-toggle="modal" data-target="#myModal" otherfiles="others" fileid="' + result.id + '" filetype="' + result.type + '">\n\
                                    <div class="gq-del-evidence"></div></a>\n\
                                <div class="tooltip-home top">\n\
                                    <div class="tooltip-arrow"></div>\n\
                                    <span class="">Delete ID File</span>\n\
                                </div>\n\
                            </span>\n\
                            <a href = "' + amazon_link + result.path + '" class="fancybox fancybox.iframe"><div class="gq-id-files-content-icon-wrap gq-id-files-content-doc-icon"></div></a><div class="gq-id-files-content-row-wrap"><div class="gq-id-files-content-row"><label>Title</label><span>' + name[0] + '</span></div><div class="gq-id-files-content-row"><label>Added on</label><span>' + result.date + '</span></div></div></div></div>';
                if ($('#reference_no_files').html() === 'No Industry and VET Currency found') {
                    $('.reference_files').html(html);
                } else {
                    $('.reference_files').append(html);
                }
                $('#resume_msg').css("display", "block");
            }
        },
        resetForm: true
    });
}
$("#matrix_browse").change(function() {
    if($('#matrixUpload').length) 
    {
            assessorTrainerMatrixUpload();
    }
});
function checkspace(text)
{
    var str = text.value;
    var first = str.substring(0, 1);
    var second = str.substring(0, 1);
    var val = 'false';
    if (first == ' ')
    {
        val = 'true';
        if (val == 'true')
        {
            if (second == ' ')
            {
                val = 'true';
                text.value = "";
            }
        }
    }
}

function checkCurrentPassword(mypassword)
{
    $("#hdn_pwd_check").val("0");
    var startdiv = '<div class="gq-id-pwd-error-text alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    var mypassword = mypassword;
    //$("#pwd_error").html(startdiv + 'Please wait till password gets validated' + enddiv);
    if(mypassword!="") {
       // $("#pwd_error").show();
        //$("#pwd_error").html('<div class="gq-id-files-upload-wait-text"><h2>Please wait..' + enddiv);
         var pswd_validation = $.parseJSON($.ajax({
        type: "POST",
        url:  'checkMyPassword',
        dataType: "json", 
        async: false,
        data: {mypassword: mypassword}
    }).responseText);
        return pswd_validation['status'];
    }
}
$(".notes-area").keypress(function() {
    //$(this).css("border","none");
});
$(".date-area").change(function() {
    $(this).css("border","none");
});


$(".setNotes").click(function() {
    id = $(this).attr("id");
    var c = $('#div_' + id).hasClass("open");
    $(".notes-area, .date-area").css("border","none");
    if (c == false) {
        if($(".gq-assessor-list-dropdown-wrap").hasClass("open"))
            $(".gq-assessor-list-dropdown-wrap").removeClass('open');
        $(this).parent().addClass('open');
        //$('#div_' + id).addClass('open');
    } else {
        
        resetDateTimePicker(id);
        $(this).parent().removeClass('open');
        //$('#div_' + id).removeClass('open');
    }
    setnotesid = false;        
});

$(".setUsers").click(function() {
    id = $(this).attr("id");
    var c = $('#div_' + id).hasClass("open");
    if (c == false) {
        if($(".gq-assessor-list-dropdown-wrap").hasClass("open"))
            $(".gq-assessor-list-dropdown-wrap").removeClass('open');
        $(this).parent().addClass('open');
    } else {
        $(this).parent().removeClass('open');
    }
    $( ".gq-name-facilitator-list" ).each(function() {
       if($(this).hasClass("selectedfacilitatornew"))
          $(this).addClass('selectedfacilitator');
       else
          $(this).removeClass('selectedfacilitator');
    });
    $( ".gq-name-list" ).each(function() {
       if($(this).hasClass("selectednew"))
          $(this).addClass('selected');
       else
          $(this).removeClass('selected');
    });
    $( ".gq-rto-list" ).each(function() {
       if($(this).hasClass("selectedRtonew"))
          $(this).addClass('selectedrto');
       else
          $(this).removeClass('selectedrto');
    });    
});



$(".setData").click(function() {
	$("#profile_suc_msg").hide();
    userCourseId = $(this).attr("userCourseId");
    reminderTypeId = $(this).attr("reminderTypeId");
    reminderType = $(this).attr("reminderType");
    listId = $(this).attr("listId");

    if( $('.dashboard').length > 0 ){
        var prefixId = $(this).attr("prefix");
        var reminderDateId = '#'+prefixId+'_remindDate_' + listId;
        var courseId = $('#'+prefixId+'_course_' + listId).val();
        note = $('#'+prefixId+'_notes_' + listId).val();
        remindDate = $(reminderDateId).val();
    } else {
        var courseId = $('#course_' + listId).val();
        note = $('#notes_' + listId).val();
        remindDate = $('#remindDate_'+listId).val();
		reminderDateId = '#remindDate_'+listId;
    }
    if (courseId != '' && typeof courseId !== 'undefined') {
        userCourseId = courseId;
    }
    /*if (note === '') {
        $('#notes_' + listId).focus();
        $('#notes_' + listId).css("border","1px solid red");
        return false;
    }*/
    if($(this).hasClass('noteSet')){
        if ($('#note_notes_note').val() == '') {
            $('#note_notes_note').focus();
            $('#note_notes_note').css("border","1px solid red");
            return false;
        } else {
            $('#note_notes_note').css("border","1px solid #d8d8d8");
        }
        if(!isNaN(listId)){
            if ($('#notes_' + listId).val() == '') {
                $('#notes_' + listId).focus();
                $('#notes_' + listId).css("border","1px solid red");
                return false;
            } else {
                $('#notes_' + listId).css("border","1px solid #d8d8d8");
            }
        }
    }

    if (remindDate === '') {
        $(reminderDateId).focus();
        $(reminderDateId).css("border","1px solid red");       
        return false;
    }
    var currEle = $(this).parent().parent().parent();
    var stPos = {topPos:($(currEle[0]).offset().top),leftPos:$(currEle[0]).offset().left};
    var newTodoItemElement = false;
     
    if( $('.dashboard').length > 0 ){
        var todoIcon = (reminderType == 'evidence') ? 'cloud_upload': ((reminderType=='portfolio')? 'account_circle': (reminderType=='message')? 'message': 'edit'); 
        var itemElement = $(this).parent().parent().parent().find('.content');
        var itemContent = itemElement.text();
        var itemLink = itemElement.find('a').attr('href');
        
        if(note != '' && note != 'undefined')
            itemContent = itemContent+' - '+note;
        
        if($(this).hasClass('noteSet')){
            itemContent = note;
        }

        var contentSub = '';
        if(itemContent.length > 64 )
            contentSub = itemContent.substring(0, 64)+'...';
        else 
            contentSub = itemContent;

        newTodoItemContent = '<li class="list_item clearfix todoContent"><a class="clearfix tool_tip"><span class="list_icon"><i class="material-icons message">'+todoIcon+'</i></span><span class="content bold">'+contentSub+'</span></li></a>';
        if(todoIcon == 'edit')
            newTodoItemElement = '<li class="list_item clearfix todoContent"><a class="clearfix tool_tip" title="'+getDisplayDate(remindDate)+itemContent+'"><span class="list_icon"><i class="material-icons message">'+todoIcon+'</i></span><span class="content bold">'+getDisplayDate(remindDate)+contentSub+'</span></a><div class="checkbox_outer"><input data-todotype="'+reminderType+'" data-todotypeid="reminderId" type="checkbox" id="reminderId" class="todomodalClass" data-status="0" data-toggle="modal" data-target="#confirm_popup"><span></span></div></li>';
        else 
            newTodoItemElement = '<li class="list_item clearfix todoContent"><a class="tool_tip" target="_blank" data-reminderid="reminderId" data-status="0" title="'+getDisplayDate(remindDate)+itemContent+'" href="'+itemLink+'"><span class="list_icon"><i class="material-icons message">'+todoIcon+'</i></span><span class="content bold">'+getDisplayDate(remindDate)+contentSub+'</span></a><div class="checkbox_outer"><input data-todotype="'+reminderType+'" data-todotypeid="reminderId" type="checkbox" id="reminderId" class="todomodalClass" data-status="0" data-toggle="modal" data-target="#confirm_popup"><span></span></div></li>';

        var todayDate = new Date();
        var todayMonth = todayDate.getMonth() + 1;
        var todayDay = todayDate.getDate();
        var todayYear = todayDate.getFullYear();

        if(todayMonth < 10)
            todayMonth = '0'+todayMonth;
        
        if(todayDay < 10)
            todayDay = '0'+todayDay;


        var todayDateText =  todayYear + "-" + todayMonth + "-" + todayDay;
        var selectedDate = remindDate.split('/');
        var selectedYear = selectedDate['2'].substring(0, selectedDate['2'].indexOf(' '));
        var selectedDateText =  selectedYear + "-" + selectedDate[1] + "-" + selectedDate[0];
        var addToToDo = true;
        if (Date.parse(todayDateText) < Date.parse(selectedDateText)) {
            addToToDo = false;
        }
        
        var statusTxt = $('.status-txt');
        var thumbTxt = $('.thumb-txt');
        var viewContent = '';
        var thumbTxtContent = 'thumb_up';        
    }

    var completedItem = 0;
    if (remindDate != '') {
        $.ajax({
            type: "POST",
            url: "addReminder",
            cache: false,
            data: {message: note, userCourseId: userCourseId, remindDate: remindDate, listId: listId, reminderTypeId: reminderTypeId, reminderType:reminderType},
            success: function(result) {
                $('.progres_bar_sec').removeClass('hide');
                var res = $.parseJSON(result);
                $('#err_msg').show();           
                $("#err_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Reminder added succesfully!</span></div>').delay(3000).fadeOut(100);
				$('.body_section').scrollTop(0);
                if(newTodoItemElement && addToToDo) {
                   
                    newTodoItem = newTodoItemElement.replace(/reminderId/g, res.reminderId);
                    flyToElement(newTodoItemContent, $('.todo-list'),stPos);
                    setTimeout(function(){$('.todo-list').append(newTodoItem);},1000);
                    totalItem = parseInt($('.progress-bar').attr('data-titem'));
                    $('.todo-list li.emptyPendingTodo').addClass('hide');
                    $('.progress-bar').attr('data-titem', totalItem+1);

                    completedItem = parseInt(completedItem) + parseInt($('.progress-bar').attr('data-citem'));
                    totalItem = parseInt($('.progress-bar').attr('data-titem'));
                    percentage = (completedItem/totalItem)*100;
                    $('.progress-bar').css('width', percentage+"%").attr('data-citem', completedItem);
                    $('.todo-percent').html(Math.ceil(percentage));
                    
                    if (Math.ceil(percentage) >= '90' && Math.ceil(percentage) < '100')
                    {
                        viewContent =  'ALMOST DONE';
                    } else if(Math.ceil(percentage) >= '100') {
                        viewContent =  'NICE WORK!';
                    } else {
                        viewContent =  '';
                        thumbTxtContent =  '';
                    }

                    if(statusTxt.text().trim().length == '0' || statusTxt.text().trim() != viewContent )
                        statusTxt.html(viewContent);
                        thumbTxt.html(thumbTxtContent);
                }
            }
        });
        if(todoIcon != 'edit'){
            var parentDiv = $(this).parent().parent().parent();
            parentDiv.addClass('disable').find('.dropdown-menu').addClass('hide');
            parentDiv.find('.material-icons').html('').html('playlist_add_check');
        } else {
            $('#note_notes_note').val('');
            $('#note_remindDate_note').val('');
            $('#note_remindDate_note').css("border","1px solid #d8d8d8");
        }
    }
});
/*Messages Unread Count in Menu*/
function onloadCount()
{
    
    $.ajax({
        url: base_url + "unread",
        cache: false,
        success: function(result) {
            if (result > 0) {
                $("#unread-count").text(result);
                $(".inbox-cnt").text("(" + result + ")");
				$("#messageCount").attr('class', '');
            } else {
                $("#unread-count").css("display","none");
                $(".inbox-cnt").text("");
				$("#messageCount").attr('class', 'hide');
            }
        }
    });
}
/*Portfolio Current Count in Menu*/
function onloadPortfolioCount()
{    
    $.ajax({
        url: base_url + "unreadApplicantCount",
        cache: false,
        success: function(result) {         
            if (result >= 0) {    
                if(result==0)
                {
                    $('#portfolioCount').css("display","none");
                }
                $(".portfolio-current").text(result);
				$("#portfolioCount").attr('class', '');	
//                    if(window.parent.opener) window.parent.opener.location.reload();
            } else {                
                $(".portfolio-current").css("display","none");
            }
        }
    });
}
$(".markasread").click(function() {
    var checkedids = getCheckedBoxes();
    if (checkedids) {
        if (checkedids.length > 0) {
            $(".markasread").attr('data-target', '');
            $(".msg-ajax-loader").show();
            var checkedMessages = JSON.stringify(getCheckedBoxes());
            var checkedids = getCheckedBoxes();
            $.ajax({
                type: "POST",
                url: base_url + "markasread",
                data: {checkedMessages: checkedMessages, readStatus: 1},
                success: function(result) {
                    var rec = result.split("&&");
                    if (rec[1] == "success") {
                        $(".msg-ajax-loader").hide();
                        for (var i = 0; i < checkedids.length; i++) {
                            $("#chk-" + checkedids[i]).prop('checked', false);
                            $("#msg-" + checkedids[i]).addClass("gq-msg-visited");
                            $("#chk-" + checkedids[i]).prev().removeClass("checked");
                        }
                        if (parseInt(rec[0]) > 0) {
                            $(".inbox-cnt").html("(" + rec[0] + ")");
                            $("#unread-count").html('<span class="gq-ms-counter">' + rec[0] + '<span>');
							$("#messageCount").attr('class', '');	
                        } else {
                            $(".inbox-cnt").html("");
                            $("#unread-count").html("");
							$("#messageCount").attr('class', 'hide');	
                        }
                        $("#chk-main-all").prop('checked', false);
                        $("#chk-main-all").prev().removeClass("checked");
                        $("#messages-grid").children(".gq-msg-row-bg").removeClass("gq-msg-selected");
                    }

                }
            });
        }
    } else {
        $(".markasread").attr('data-target', '#mySelectModal');
    }
});


$(".markasunread").click(function() {
    var checkedids = getCheckedBoxes();
    if (checkedids) {
        if (checkedids.length > 0) {
            $(".markasunread").attr('data-target', '');
            $(".msg-ajax-loader").show();
            var checkedMessages = JSON.stringify(getCheckedBoxes());
            var checkedids = getCheckedBoxes();
            $.ajax({
                type: "POST",
                url: base_url + "markasread",
                data: {checkedMessages: checkedMessages, readStatus: 0},
                success: function(result) {
                    var rec = result.split("&&");
                    if (rec[1] == "success") {
                        $(".msg-ajax-loader").hide();
                        for (var i = 0; i < checkedids.length; i++) {
                            $("#chk-" + checkedids[i]).prop('checked', false);
                            $("#msg-" + checkedids[i]).removeClass("gq-msg-visited");
                            $("#chk-" + checkedids[i]).prev().removeClass("checked");
                        }
                        if (parseInt(rec[0]) > 0) {
                            $(".inbox-cnt").html("(" + rec[0] + ")");
                            $("#unread-count").html('<span class="gq-ms-counter">' + rec[0] + '<span>');
							$("#messageCount").attr('class', '');	
                        } else {
                            $(".inbox-cnt").html("");
                            $("#unread-count").html("");
							$("#messageCount").attr('class', 'hide');	
                        }
                        $("#chk-main-all").prop('checked', false);
                        $("#chk-main-all").prev().removeClass("checked");
                        $("#messages-grid").children(".gq-msg-row-bg").removeClass("gq-msg-selected");
                    }
                }
            });
        }
    } else {
        $(".markasunread").attr('data-target', '#mySelectModal');
    }
});

$(".deleteMessages").click(function() {
    var checkedMessages = JSON.stringify(getCheckedBoxes());
    $(".msg-loader").show();
    $.ajax({
        type: "POST",
        url: base_url + "deleteFromUser",
        data: {checkedMessages: checkedMessages, type: 'to'},
        async: false,
        success: function(result) {
        }
    });
    checkboxes = document.getElementsByName('chk_inbox');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = false;
    }
    location.reload();
});

$(".deleteselected").click(function() {
    var checkedids = getCheckedBoxes();
    if (checkedids) {
        if (checkedids.length > 0) {
            $(".deleteselected").attr('data-target', '#myModal');
        }
    } else {
        $(".deleteselected").attr('data-target', '#mySelectModal');
    }
});

$(".deleteselectedsent").click(function() {
    $(".msg-loader").show();
    var checkedMessages = JSON.stringify(getCheckedBoxes());
    $.ajax({
        type: "POST",
        url: base_url + "deleteFromUser",
        async: false,
        data: {checkedMessages: checkedMessages, type: 'from'},
        success: function(result) {
        }
    });
    checkboxes = document.getElementsByName('chk_inbox');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = false;
    }
    location.reload();
});


$(".deleteTrash").click(function() {
    $(".msg-loader").show();
    var checkedMessages = JSON.stringify(getCheckedBoxes());
    $.ajax({
        type: "POST",
        url: base_url + "deleteFromTrash",
        async: false,
        data: {checkedMessages: checkedMessages},
        success: function(result) {
        }
    });
    checkboxes = document.getElementsByName('chk_inbox');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = false;
    }
    location.reload();
});

var applicantStatus = '0';
function loadDataIcon(listdiv)
{
    var ajaxLoadImg = $("#ajaxHtml").html();
    if(listdiv == "currentList")
        var tdcolspan = $("#ajaxHtml").attr("tdcolspan");
    else
        var tdcolspan = $("#ajaxHtml").attr("tdrtocolspan");
    var ajaxLoadHTML = '<tr class="load-icon-tr"><td colspan="'+tdcolspan+'">'+ajaxLoadImg+'</td></tr>'; 
    $("#"+listdiv).html(ajaxLoadHTML);
}
/*$("#timeRemaining").change(function() {
    pagenum = 1;
    loadDataIcon('currentList');
    loadApplicantList('currentList');
});*/



$("#applicantPending").click(function() {
    $("#search-current").focus();
    $("#searchName").val("");
    $("#searchName").hide();
    $("#search-current").show();
    $('#filterByStatus').val('0');
    pagenum = 1;   
    loadDataIcon('currentList');
    applicantStatus = '0';
    $("#completed").css("display", "none");
    $("#current").css("display", "block");
   // $("#remainingweekDiv").show();
    loadApplicantList('currentList',pagenum);
     $("#ajaxHtml img").css({'display':'table','margin':'0 auto'})
     
});
$("#search-current").keyup(function(event) {
  setTimeout(function(){   if ($('#search-current').val() != "")
    {
        if ($("#currentList tr:visible").length == 0)
        {
           var noRecordsContent = '<tr><td colspan="6">No Applicants Found</td></tr>';       
         
             $('#currentList').append(noRecordsContent);
              // console.log('adding elelemnts set time',noRecordsContent);
         //  console.log('adding elelemnts ',noRecordsContent);
          $('#search-current').blur();
        }
        else
            $('#emptyResult').hide();
            $('.gq-pagination-area').hide();
            var key = event.keyCode || event.which;
            if(key == 13)  //  // 
            {
            $('#search-current').blur();
        }
    }
    else
        $('.gq-pagination-area').show(); },300);
});
$("#searchName").keyup(function(event) {
    if ($('#searchName').val() != "")
        $('.gq-pagination-area').hide();
    else
         $('.gq-pagination-area').show();
      
           var key = event.keyCode || event.which;
            if(key == 13)  //  // 
            {  //            
            $('#searchName').blur();
        }
});
$("#applicantCompleted").click(function() {
    $(".days-list").css('visibility','hidden');
    $("#search-current").val("");
    $("#searchName").show();
    $("#search-current").hide();
    $('#filterByStatus').val('0');
    pagenum = 1;
    loadDataIcon('completedList');
    applicantStatus = '1';
    //$("#remainingweekDiv").hide();
    $("#completed").css("display", "block");
    $("#current").css("display", "none");
    loadApplicantList('completedList',pagenum);
     $("#ajaxHtml img").css({'display':'table','margin':'0 auto'})
});

$("body").on("click", ".gq-ajax-app-pagination", function() {   
    pagenum = $(this).attr("page");
    if(applicantStatus==0)
    {
        loadDataIcon('currentList');
        loadApplicantList('currentList',pagenum);
    }
    if(applicantStatus==1)
    {
        loadDataIcon('completedList');
        loadApplicantList('completedList',pagenum);
    }
});


$("body").on("click", ".gq-ajax-pagination", function() {   
    pagenum = $(this).attr("page");
    loadDataIcon('currentList');
    loadApplicantListReports('currentList',pagenum);
});

$("body").on("click", ".gq-ajax-users-pagination", function() {   
    pagenum = $(this).attr("page");
    loadDataIcon('currentList');
    loadUsersList('currentList');
});

$("body").on("click", ".gq-ajax-pagination", function() {   
    pagenum = $(this).attr("page");
    loadDataIcon('currentList');
    loadApplicantListReports('currentList',pagenum);
});

$("#searchNameForReports").keyup(function() {
    pagenum = 1;
    loadDataIcon('currentList');
    loadApplicantListReports('currentList',pagenum);
});

$("#searchFilterReports").click(function() { 
    pagenum = 1;    
    loadDataIcon('currentList');
    loadApplicantListReports('currentList',pagenum);
});
$("#searchFilter").click(function() {   
    pagenum = 1;    
    if(applicantStatus==0)
    {
        loadDataIcon('currentList');
        loadApplicantList('currentList',pagenum);
    }
    if(applicantStatus==1)
    {
        loadDataIcon('completedList');
        loadApplicantList('completedList',pagenum);
    }
});
$(".search-box").keyup(function (e) {   
    pagenum = 1;        
    if(applicantStatus==0)
    {      
        loadDataIcon('currentList');
        loadApplicantList('currentList',pagenum);
    }
    if(applicantStatus==1)
    {
        loadDataIcon('completedList');
        loadApplicantList('completedList',pagenum);
    }  
});
$('#searchAge').change(function(e) {
    pagenum = 1;        
    if(applicantStatus==0)
    {      
        loadDataIcon('currentList');
        loadApplicantList('currentList',pagenum);
    }
    if(applicantStatus==1)
    {
        loadDataIcon('completedList');
        loadApplicantList('completedList',pagenum);
    }  
});
$(".search-box-mobile").keypress(function () {     
    if(applicantStatus==0)
    {      
        loadDataIcon('currentList');
        loadApplicantList('currentList',pagenum);
    }
    if(applicantStatus==1)
    {
        loadDataIcon('completedList');
        loadApplicantList('completedList',pagenum);
    }
    //}
});
function loadApplicantList(divContent)
{
 searchName = $('#searchName').val();
 filterByUser = $('#filterByUser').val();
 filterByStatus = $('#filterByStatus').val(); 
 searchAge = $('#searchAge').val(); 
    $.ajax({
        type: "POST",
        url: base_url + "searchApplicantsList",
        cache: false,
        data: {pagenum: pagenum, searchName: searchName, searchTime: '', status: applicantStatus, filterByUser: filterByUser, filterByStatus: filterByStatus, searchAge: searchAge},
        success: function(result) {                       
           $("#filter-by-name").hide();
            $("#filter-by-week").hide();
            $("#app-pending-approve").hide();
            $('#' + divContent).html(result);
        }
    });
}

function loadApplicantListReports(divContent, pagenum)
{
    searchName = $('#searchNameForReports').val();
    searchAge = $('#searchAge').val();
    searchRoleId = $('#searchRoleId').val();
    $.ajax({
        type: "POST",
        url: base_url + "searchApplicantsListReports",
        cache: false,
        data: {pagenum:pagenum, searchName: searchName, searchAge: searchAge, searchRoleId: searchRoleId},
        success: function(result) { 
            $("#current").show();
            $("#filter-by-all").hide();
            $('#' + divContent).html(result);
        }
    });
}

function getCompletedtabData()
{
    var data = "this is ajax data";
    $("#completed-tab").html(data);
}

/*Messages*/
function inboxcheckall() {
    if (document.getElementById("chk-main-all").checked == true)
    {
        checkboxes = document.getElementsByName('chk_inbox');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = true;
        }
        $(".custom-checkbox").addClass("checked");
        $(".custom-checkbox").parent().parent().parent().addClass("gq-msg-selected");
    }
    else
    {
        checkboxes = document.getElementsByName('chk_inbox');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = false;
        }
        $(".custom-checkbox").removeClass("checked");
        $(".custom-checkbox").parent().parent().parent().removeClass("gq-msg-selected");
    }
}

function uncheckall() {
    checkboxes = document.getElementsByName('chk_inbox');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = false;
    }
    $(".custom-checkbox").removeClass("checked");
    $(".custom-checkbox").parent().parent().parent().removeClass("gq-msg-selected");
}

function getCheckedBoxes() {
    var checkboxes = document.getElementsByName('chk_inbox');
    var checkboxesChecked = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkboxesChecked.push(checkboxes[i].value);
        }
    }
    return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}
function getAllCheckBoxes() {
    var checkboxes = document.getElementsByName('chk_inbox');
    var checkboxesChecked = [];
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxesChecked.push(checkboxes[i].value);
    }
    return checkboxesChecked.length > 0 ? checkboxesChecked : 0;
}

/*End Messages*/

$(".date-icon").click(function() {
    remId = $(this).attr("id");
    $("#remindDate_" + remId).datepicker("show");
});


function uncheckSpecificCB(chkid)
{
    if($("#chk-" + chkid).parent().parent().parent().hasClass("gq-msg-selected")) {
        $("#chk-" + chkid).parent().parent().parent().removeClass("gq-msg-selected");
    } else {
        $("#chk-" + chkid).parent().parent().parent().addClass("gq-msg-selected");
    }
    $("#main-chk-id").removeClass("checked");
    document.getElementById("chk-main-all").checked = false;
    if ($("#chk-" + chkid).prev().hasClass("checked")) {
        $("#chk-" + chkid).prev().removeClass("checked");
    } else {
        $("#chk-" + chkid).prev().addClass("checked");
    }
    var allcheckboxids = getAllCheckBoxes();
    var checkedids = getCheckedBoxes();
    if (allcheckboxids.length == checkedids.length) {
        $("#main-chk-id").addClass("checked");
        document.getElementById("chk-main-all").checked = true;
    }
}


$("#disclose-cancel").click(function() {
    $("#disclose").trigger("click");
});

$("form :input").change(function() {
    $(this).closest('form').data('changed', true);
});
$('.checkform-changed').click(function() {
    if ($(this).closest('form').data('changed')) {
        $(this).attr("data-target", "#myModal");
        return true;
    }
    else
    {
        location.href = base_url + "messages";
    }
});


$("#userprofile_save").click(function() {    
    return validateAddress();
});
function showMyTabs(msg)
{
    var startMsg = '<div class="gq-id-address-error-text alert alert-danger"><h2>';
    var endMsg = '</h2></div>';
    $("#change_address_error").show();
    $("#change_address_error").html(startMsg + msg + endMsg);
}
function checkPhonenumber(inputtxt)
{
    var phoneno = /^[0-9+-]*$/;
    if(inputtxt.match(phoneno)) {
        return "1";
    }
    else {
        return "0";
    }
}  
function validateAddress()
{    
  
    var userrole = $("#hdn-userrole").val();
    var useremail = $("#userprofile_email").val();
    
    $("#change_address_error").hide();
    $("#profile_suc_msg2").hide();
    $("#profile_suc_msg").hide();   
   // $("#resume_msg").hide();
    var userType = $("#hdn-type").val(); //0: edit profile, 1: edit user, 2: add user
    regexp = /^[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/;
    country = /^[a-zA-Z\s]+$/;
    postcode = /^[a-zA-Z0-9\s]+$/;
    //phone = /^\(?([0-9]{4})\)?[-]?([0-9]{3})[-]?([0-9]{3})$/;
    phone =/^[ 0-9]*$/;
    $('#userprofile').find('input').each(function(index){
	  	if($(this).attr('isChanged')!=undefined && $(this).attr('isChanged')=="1"){
			$(this).prev().removeAttr('style');
		}
	 	if($(this).attr('isChanged')!=undefined){
			$(this).removeAttr('isChanged')
		}
    });
    
    if ($("#userprofile_firstname").val() == "") {
        if(userrole=='rtouser')
            showMyTabs("Please enter College Name");
        else
            showMyTabs("Please enter First Name");
        $("#userprofile_firstname").focus();
		$('.body_section').scrollTop(0);
        return false;
    }
    if ($("#userprofile_lastname").val() == "") {
        if(userrole=='rtouser')
            showMyTabs("Please enter Provider Code");
        else
            showMyTabs("Please enter Last Name");
        $("#userprofile_lastname").focus();
		$('.body_section').scrollTop(0);
        return false;
    }
    if ($("#userprofile_email").val() == "") {
        showMyTabs("Please enter Email");
        $("#userprofile_email").focus();
		$('.body_section').scrollTop(0);
        return false;
    }
    if ($("#userprofile_email").val() != "") {
        if (useremail.search(regexp) == -1) {
            showMyTabs("Please enter valid Email");
            $("#userprofile_email").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    }
    if (userType == 2 || (userType == 1 && ($("#hdn-email").val() != useremail)) ) {
        var count = checkEmailExist($("#userprofile_email").val());
        if (count > 0) {
            showMyTabs("This Email already exist!");
            $("#userprofile_email").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    }
   
    if ($("#userprofile_phone").val() == "") {
        showMyTabs("Please enter Phone number");
        $("#userprofile_phone").focus();
		$('.body_section').scrollTop(0);
        return false;
    }
    if((userrole=='facilitatoruser') || (userrole=='assessortoruser') || (userrole=='manager') || (userrole=='superadmin')) {
     if ($("#userprofile_phone").val() != "") {
         var uphoneVal = $("#userprofile_phone").val();
          var uphone = uphoneVal.replace(/\s/g, "");        
             if (uphone.length < 10) {        
                showMyTabs("Please enter valid phone number");
                $("#userprofile_phone").focus();
				$('.body_section').scrollTop(0);
                return false;
        }   
            if ((uphone.length >= 12) || (uphone.search(phone) == -1 ) ) {
                    
                    showMyTabs("Please enter valid phone number");
                    $("#userprofile_phone").focus();
					$('.body_section').scrollTop(0);
                    return false;
                
            }
    }
}
    
    if(userrole=='applicant') {
    if ($("#userprofile_universalStudentIdentifier").val() == "") {
        showMyTabs("Please enter USI");
        $("#userprofile_universalStudentIdentifier").focus();
        return false;
    } else if ($("#userprofile_universalStudentIdentifier").val() != "") {
        var USI = $("#userprofile_universalStudentIdentifier");
        if(USI.length != 10) {
            showMyTabs("Please enter 10 characters USI");
           return false;
        } else if (USI.match(/[^a-zA-Z0-9 ]/g)) {
           showMyTabs("Please enter only ALPHA Numeric USI");
           return false;
        }
    }
    }
    if((userrole=='rtouser') || (userrole=='assessortoruser') || (userrole=='applicant')) {
   if ($("#userprofile_address_address").val() == "") {
        $("#change_address_error").show();       
        showMyTabs("Please enter address");        
        $("#userprofile_address_address").focus();
		$('.body_section').scrollTop(0);
        return false;
    } 
    if ($("#userprofile_address_area").val() == "") {
            showMyTabs("Please enter Street Name");
            $("#userprofile_address_area").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
        if ($("#userprofile_address_suburb").val() == "") {
            showMyTabs("Please enter Suburb");
            $("#userprofile_address_suburb").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
        if ($("#userprofile_address_city").val() == "") {
            showMyTabs("Please enter City");
            $("#userprofile_address_city").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    else { 
        if ($("#userprofile_address_city").val().search(country) == -1) {
            $("#userprofile_address_city").val('');
            showMyTabs("Please enter alphabets  only");             
            $("#userprofile_address_city").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    }
   if ($("#userprofile_address_state").val() == "") {
            showMyTabs("Please enter State");
            $("#userprofile_address_state").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    else { 
        if ($("#userprofile_address_state").val().search(country) == -1) {
            $("#userprofile_address_state").val('');
            showMyTabs("Please enter alphabets  only");             
            $("#userprofile_address_state").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    }
    if ($("#userprofile_address_pincode").val() == "") {
            showMyTabs("Please enter Postcode");
            $("#userprofile_address_pincode").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    else { 
        if ($("#userprofile_address_pincode").val().search(postcode) == -1) {
            $("#userprofile_address_pincode").val('');
            showMyTabs("Please enter alphabets and numbers only");             
            $("#userprofile_address_pincode").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    }
     if ($("#userprofile_address_country").val() == "") {
            showMyTabs("Please enter Country");
            $("#userprofile_address_country").focus();
			$('.body_section').scrollTop(0);
            return false;
        }else { 
        if ($("#userprofile_address_country").val().search(country) == -1) {
            $("#userprofile_address_country").val('');
            showMyTabs("Please enter alphabets only");             
            $("#userprofile_address_country").focus();
			$('.body_section').scrollTop(0);
            return false;
        }
    }
    }
    if(userrole=='rtouser') {
        if ($("#userprofile_contactname").val() == "") {
            showMyTabs("Please enter Contact Person Name");
            $("#userprofile_contactname").focus();
			$('.body_section').scrollTop(0);
            return false;
        }        
        if ($("#userprofile_contactphone").val() == "") {
        showMyTabs("Please enter Phone");
        $("#userprofile_contactphone").focus();
		$('.body_section').scrollTop(0);
        return false;
    }
    if ($("#userprofile_contactphone").val() != "" && $("#userprofile_contactphone").val().length < 10) {        
            showMyTabs("Please enter valid phone number");
            $("#userprofile_contactphone").focus();
			$('.body_section').scrollTop(0);
            return false;
    }
    if ($("#userprofile_contactphone").val() != "" && $("#userprofile_contactphone").val().length >= 12 &&  ($("#userprofile_contactphone").val().search(phone) == -1 )) {        
            showMyTabs("Please enter valid phone number");
            $("#userprofile_contactphone").focus();
			$('.body_section').scrollTop(0);
            return false;
    }
        
    }
    
return true;
    
}

/* function to check email already exist */
function checkEmailExist(emailId) {
    var count = '';
    $.ajax({
        type: "POST",
        url: base_url + "checkEmailExist",
        async: false,
        data: {emailId: emailId},
        success: function(result) {           
           count = result;
        }
    });
    return count;
}

/* Change Password Validations */
function passwordShowMsg(errorMsg,msgId)
{
    var startdiv = '<div class="gq-id-pwd-error-text alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    $("#pwd_error").show();
    $("#pwd_error").html(startdiv + errorMsg + enddiv);
    if($("#"+msgId).val() != "")
        $("#"+msgId).val('');
    $("#"+msgId).focus();
}

$("#password_newpassword,#password_confirmnewpassword").keyup(function() {
    checkspace(this);
});
$("#emptypwdform").click(function() {
    $("#gq-profile-tabs-headerid").show();
    $("#password_oldpassword").val('');
    $("#password_newpassword").val('');
    $("#password_confirmnewpassword").val('');
});
$("#emptypwdform1 ").click(function() {
    $("#gq-profile-tabs-headerid").hide();
    $("#password_oldpassword").val('');
    $("#password_newpassword").val('');
    $("#password_confirmnewpassword").val('');
});
/*End Change Password validations*/

$("#approve-for-certification, #approve-for-certification-ajax").click(function() {
    var courseCode = $(this).attr("courseCode");
    var applicantId = $(this).attr("applicantId");
    $(this).hide();
    $("#approve_loader_fac_ajax").show();
    $.ajax({
        type: "POST",
        url: base_url + "approveCertification",
        async: false,
        data: {courseCode: courseCode, applicantId: applicantId},
        success: function(result) {
            $("#approve_loader_fac_ajax").hide();
            $('#approve_sectionajax').show();
            $("#approve_sectionajax").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span> Certificate issued successfully!</span></div>');
            $("#approve_section-status").show();
            $("#status_arc").show();
            $("#courseStatusCodeName").html('<img src="' + base_url + 'public/images/status.png">Certificate Received By GQ');
        }
    });
});

$("#approve-for-rto").click(function() {
    var courseCode = $(this).attr("courseCode");
    var applicantId = $(this).attr("applicantId");
    $("#approve_loader_fac_ajax").show();
    $.ajax({
        type: "POST",
        url: base_url + "approveForRTO",
        async: false,
        data: {courseCode: courseCode, applicantId: applicantId},
        success: function(result) {
            $("#approve_section_fac_ajax").show();
            $("#approve_loader_fac_ajax").hide();
            $('#approve_section').show();
            $("#approve_section").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Portfolio submited to RTO!</span></div>');
            $("#status_ar").show();
        }
    });
});
$("body").on('click', '#approve-all-units-from-rto', function() {
    var courseCode = $(this).attr("courseCode");
    var applicantId = $(this).attr("applicantId");
    $("body #status-message").show();
    $("body #status-message").html('<img src="' + base_url + 'public/images/loading.gif">');
    $.ajax({
        type: "POST",
        url: base_url + "approveAllUnitsFromRTO",
        async: false,
        data: {courseCode: courseCode, applicantId: applicantId},
        success: function(responseText) {
            var result = jQuery.parseJSON(responseText);
            if(result.type == 'Error' ) {
                $("body #status-message").html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2> '+ result.msg+'</h2></div>');
                window.scrollTo(0, 0);
            } else if (result.type == 'Success') {
                $( "#approve-all-units-from-rto").hide( "slow");
                $(this).hide();
                $("body #status-message").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span> '+ result.msg+'</span></div>');
                window.scrollTo(0, 0);
            } 
        }
    });
});

$(".gq-msg-title").children("a").click(function() {
    $(this).parent().parent().parent().addClass('gq-msg-visited');
});

function checkApproveButton()
{
    $(".gq-approve-error").show();
}
$("#evd_close").click(function() {
    $(".uploadevidence_loader").hide();
});
$(".changeUsers").click(function() {
    var roleid = $(this).attr("roleid");
    if(roleid == 2) {
        var newroleuserId = $(".selectedfacilitator").attr("data-value");
        var roleuserIdarr = newroleuserId.split('&&');
        var roleuserId = roleuserIdarr[0];
    }
    if(roleid == 3) {
        var newroleuserId = $(".selected").attr("data-value");
        var roleuserIdarr = newroleuserId.split('&&');
        var roleuserId = roleuserIdarr[0];
    }
    if(roleid == 4) {
        var newroleuserId = $(".selectedrto").attr("data-value");
        var roleuserIdarr = newroleuserId.split('&&');
        var roleuserId = roleuserIdarr[0];
    }
    var courseId = $("#hdn-coursePrimaryId").val();
    $.ajax({
        type: "POST",
        url: base_url + "setRoleUsers",
        async: false,
        data: {courseId: courseId, roleid: roleid, roleuserId: roleuserId},
        success: function(result) {
            res = JSON.parse(result);
            if(roleid == 2) {
                $(".gq-facilitator-select-name").html(roleuserIdarr[1]);
                $(".facilitator-change").children(".setUsers").trigger("click");
            }
            if(roleid == 3) {
                $(".gq-assessor-select-name").html(roleuserIdarr[1]);
                $(".assessor-change").children(".setUsers").trigger("click");
            }
            if(roleid == 4) {
                $(".gq-rto-select-name").html(roleuserIdarr[1]);
                $(".rto-change").children(".setUsers").trigger("click");
                $("#rto-ceo-section").show();
                $("#ceo_name").html(res['ceoName']);
                $("#ceo_email").html(res['ceoEmail']);
                $("#ceo_phone").html(res['ceoPhone']);
            }
        }
    });

});
/*$(".gq-assessor-list-dropdown, .ui-datepicker").click(function() {
    setnotesid = false;
});
$('html').click(function() {
    if(setnotesid || setnotesid==="undefined") {
        if($(".gq-assessor-list-dropdown-wrap").hasClass("open"))
            $(".gq-assessor-list-dropdown-wrap").removeClass('open');
    }
    setnotesid = true;
});*/
$(".gq-name-facilitator-list").click(function() {
    $(".gq-name-facilitator-list").removeClass('selectedfacilitator');
    $(".gq-name-facilitator-list").removeClass('selectedfacilitatornew');
    $(this).addClass("selectedfacilitator");
    $(this).addClass("selectedfacilitatornew");
});
$(".gq-name-list").click(function() {
    $(".gq-name-list").removeClass('selected');
    $(".gq-name-list").removeClass('selectednew');
    $(this).addClass("selected");
    $(this).addClass("selectednew");
});
$(".gq-rto-list").click(function() {
    $(".gq-rto-list").removeClass('selectedrto');
    $(".gq-rto-list").removeClass('selectedRtonew');
    $(this).addClass("selectedrto");
    $(this).addClass("selectedRtonew");
});
$("#gq-name-cancel, #gq-rtoname-cancel").click(function() {
    $(this).parent().parent().prev(".setUsers").trigger("click");
});

$(".select_existing_evidence").click(function() {
   userId = $(this).attr("userid");
   unitCode = $('#unit-code').val();
   $('#select-from-evidence-tab').html('<div class="row" style="height:380px;"><div id="userEvidencesDiv" style="display: block;" class="load-icon-tr"><img src="' + base_url + '/public/images/loading.gif"></div></div>');            
   $.ajax({
        type: "POST",
        url: base_url + "getUserEvidences",
        data: {userId: userId, unit: unitCode},
        success: function(result) {
            $('#select-from').html(result);
            centerModals(modEle);
            //Custom.init();
        }
    });
});

function sumitFormEvidence() {
   var unit = $('#unit-code').val(),
       courseCode = $('#course-code').val();
    $('#select_hid_unit').val(unit);
    $('#select_hid_course').val(courseCode);
    $('#file_save').hide();
    $('.uploadevidence_loader').show();
    $('.save-existing-evidence').prop('disabled', true);
    var data = $("#frmSelectEvidence").serialize();
    $.ajax({
        type: "POST",
        url: base_url + "saveExistingEvidence",
        data: data,
        success: function(responseText) {
            $('.gq-dashboard-tabs').hide();
            $('.uploadevidence_loader').hide();
            $('#gq-dashboard-tabs-error').hide();
            $('#gq-dashboard-tabs-success').show();
            if (responseText){            
                $('#sp_'+responseText).show();
                $('#gq-dashboard-tabs-success').html('<div class="alert alert-success">Existing Evidence uploaded successfully!</div>');
                $('#frmSelectEvidence').find('input:checked').parent().html('<i class="material-icons" style="color:green;">done</i>');
                $('#uploadaction').val(1);
                $('.save-existing-evidence').prop('disabled', false);
            }
        }
    });
}
$(".fromBottomAssessment").click(function() {
    unit = $(this).attr("unitid");
    courseCode = $(this).attr("course_code");
    $('#assessmentfile_hid_unit_assess').val(unit);
    $('#assessmentfile_hid_course_assess').val(courseCode);
    $('.gq-dashboard-tabs').show();
    $('#gq-dashboard-tabs-success-assess').hide();
    $('#frmAddEvidenceAssessment')[0].reset();
});
$("#evd_close_assess").click(function() {
    $(".uploadevidence_assess_loader").hide();
});
if($('#frmAddEvidenceAssessment').length) 
{
    $("#frmAddEvidenceAssessment").ajaxForm({
        beforeSubmit: function() {
            $('#file_save').hide();
            $('.uploadevidence_assess_loader').show();
        },
        success: function(responseText, statusText, xhr, $form) {
            $("#gq-dashboard-tabs-success-assess").show();
            $('.gq-dashboard-tabs').hide();
            $('.uploadevidence_assess_loader').hide();
            var rec = responseText.split("&&");
            if (rec[0] == '0') {
                $('#gq-dashboard-tabs-error-assess').html('<h2>Assessment not added!</h2>');
            } else if (rec[0] == '1') {
                $('#gq-dashboard-tabs-success-assess').html('<h2> Assessment added successfully!</h2>');
                $('#sp_'+rec[1]).show();
            }
            setTimeout(function(){jQuery("#evd_close_assess").trigger('click');},3000);
        },
        resetForm: true
    });
}
$(".custom-close").click(function() {
    $(".gq-extra-space").hide();
    unit = $(this).attr("id");
    var c = $("#label_"+unit).hasClass("open");
    if (c == true) {
        $("#label_"+unit).trigger("click");
    }  
});
$(".fromnewBottom").click(function() {
    unit = $(this).attr("unitid");
});
$(".fromBottomAssessment").click(function() {
    unit = $(this).attr("unitid");
});

// script to close the reminder or notes while clicking outside
// script to close the reminder or notes while clicking outside
$(document).on('click', function (e) {
    if (!$('.gq-assessor-list-dropdown').is(e.target) 
        && $('.gq-assessor-list-dropdown').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0 
        && !$('#ui-datepicker-div').is(e.target) 
        && $('#ui-datepicker-div').has(e.target).length === 0 
    ) {
        
        if ( $('.gq-assessor-list-dropdown-wrap').hasClass('open') ) {
            if ( !$('.gq-assessor-list-dropdown-wrap').hasClass('gq-assessor-name-edit') ) {
                var id = $('.gq-assessor-list-dropdown-wrap').children('.setNotes').attr('id');
                resetDateTimePicker(id);
            }
            $('.gq-assessor-list-dropdown-wrap').removeClass('open');
        }        
    }
 });
 
 $(document).on('click', 'a.ui-datepicker-prev, a.ui-datepicker-next', function (e) {
    e.stopPropagation();
});

// on show evidence modal close 
$('#edivenceUnitModal').on('hidden.bs.modal', function () {
    $(".gq-extra-space").hide();
    if ( $(".gq-acc-row-bg").hasClass("active") && $(".gq-acc-row-bg.active").find("label.openIcon").hasClass("open") ) {
        $(".gq-acc-row-bg.active").find("label.openIcon").trigger("click");        
    }
});

// for validating the upload evidence form
$( '#file_save' ).click( function( e ) {
    if ($("#file_file").val().length > 0) {
        var extension = $("#file_file").val().substring($("#file_file").val().lastIndexOf('.')+1);
        var allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pdf', 'rtf', 'odt', 'PDF', 'mp3', 'mp4', 'flv', 'vob', 'avi', '3gp', 'wmv'];
        if (allowedExtensions.indexOf(extension) === -1) 
        {
          $('#gq-dashboard-tabs-error').show();
          $('#gq-dashboard-tabs-error').html('<h2><img src="' + base_url + 'public/images/login-error-icon.png">Invalid File Format !</h2>');  
        } else {
            $('#frmAddEvidence').submit();
        }
    } else {
        $('#gq-dashboard-tabs-error').show();
        $('#gq-dashboard-tabs-error').html('<h2><img src="' + base_url + 'public/images/login-error-icon.png">Please Select file to upload!</h2>');
    }
    e.preventDefault();
    return false;
});

// for validating the upload ID file
$("#userfiles_browse").click(function(evt) {
    if($("#userfiles_type").val()=="")
    {
        
        $('#change_address_error').hide();
        $('#profile_suc_msg').hide();
        $('#change_file_error').show();
        $('#change_file_error').html('<div class="gq-id-file-error-text alert alert-danger"><h2>Please Select document type!</h2></div>');
        evt.preventDefault();
    }
    $("#idfiletype_image").html("");
});
$( '#userfiles_type' ).change( function( e ) { 
	if($('#change_file_error').html()){
		$('#change_file_error').hide();
	}
	
});
$( '#userfiles_browse' ).change( function( e ) {  
     if($("#userfiles_type").val()!="") {        
        if ($("#userfiles_browse").val().length > 0) {  
           
            var extension = $("#userfiles_browse").val().substring($("#userfiles_browse").val().lastIndexOf('.')+1);
            var allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pdf', 'rtf', 'odt', 'PDF'];
            if (allowedExtensions.indexOf(extension) === -1) 
            {
              $('#change_file_error').show();
              $('#change_file_error').html('<div class="gq-id-file-error-text alert alert-danger"><h2>Invalid File Format !</h2></div>');  
            } else {
                profileIdUpload();
                //$('#Id_files').submit();
            }
        } else {
            $('#change_file_error').show();
            $('#change_file_error').html('<div class="gq-id-file-error-text alert alert-danger"><h2>Please Select file to upload!</h2></div>');
        }
    } else {
        $('#change_file_error').show();
        $('#change_file_error').html('<div class="gq-id-file-error-text alert alert-danger"><h2>Please Select document type!</h2></div>');
    }
//    e.preventDefault();
//    return false;
} );
$( '#user_enroll_browse' ).change( function( e ) {  
             
        if ($("#user_enroll_browse").val().length > 0) {  
           
            var extension = $("#user_enroll_browse").val().substring($("#user_enroll_browse").val().lastIndexOf('.')+1);
            var allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pdf', 'rtf', 'odt', 'PDF'];
            if (allowedExtensions.indexOf(extension) === -1) 
            {
              $('#change_file_error').show();
              $('#change_file_error').html('<div class="gq-id-file-error-text alert alert-danger"><h2>Invalid File Format !</h2></div>');  
            } else {
                userEnrollmentUpload();
                //$('#Id_files').submit();
            }
        } else {
            $('#change_file_error').show();
            $('#change_file_error').html('<div class="gq-id-file-error-text alert alert-danger"><h2>Please Select file to upload!</h2></div>');
        }
    
    e.preventDefault();
    return false;
} );
// for validating the upload resume file
$( '#resume_save' ).click( function( e ) {
    validateFileUpload($("#resume_browse").val(), 'resumeUpload');
    e.preventDefault();
    return false;
});

// for validating the upload qualification file
$( '#qualification_save' ).click( function( e ) {
    validateFileUpload($("#qualification_browse").val(), 'qualificationUpload');
    e.preventDefault();
    return false;
});

// for validating the upload reference file
$( '#reference_save' ).click( function( e ) {
    validateFileUpload($("#reference_browse").val(), 'referenceUpload');
    e.preventDefault();
    return false;
});

// for validating the upload matrix file
$( '#matrix_browse' ).change( function( e ) {
    validateFileUpload($("#matrix_browse").val(), 'matrixUpload');
    e.preventDefault();
    return false;
});

function validateFileUpload(fieldVal, formName) {
    if (fieldVal.length > 0) {
        var extension = fieldVal.substring(fieldVal.lastIndexOf('.')+1);
        var allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pdf', 'rtf', 'odt', 'PDF'];
        if (allowedExtensions.indexOf(extension) === -1) 
        {
          $('#change_pwd_error').show();
          $('#change_pwd_error').html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2>Invalid File Format !</h2></div>');
          $('html, body').animate({
             scrollTop: $('#change_pwd_error').offset().top
           }, 500);
        } else {
            $('#' + formName).submit();
        }
    } else {
        $('#change_pwd_error').show();
        $('#change_pwd_error').html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2>Please Select file to upload!</h2></div>');
        $('html, body').animate({
            scrollTop: $('#change_pwd_error').offset().top
         }, 500);
    }
}

function resetDateTimePicker(rmid) {
    var dateTime = new Date();
    var utc = dateTime.getTime() + (dateTime.getTimezoneOffset() * 60000);
    var timeZoneDT = new Date(utc + (3600000*+10));
    $("#remindDate_"+ rmid).datetimepicker("option", "minDate", timeZoneDT);
    $("#remindDate_"+ rmid).datetimepicker("option", "minDateTime", timeZoneDT);
    $('#remindDate_'+ rmid).datetimepicker("setDate", timeZoneDT );
    $('#notes_' + rmid).val('').attr("placeholder", "Notes");
    $('#remindDate_' + rmid).val('').attr("placeholder", "Due Date");
    
    $('#course_'+rmid+' option').prop('selected', function() {
        return this.defaultSelected;
    });
    $('#selectcourse_'+ rmid).html('Select Qualification');
}

$(".unit-notes").click(function() {
    $(".gq-extra-space").show();
    $("#myNotesTab li").removeClass("active");
    $("#myNotesTabContent div.tab-pane").removeClass("active");
    $("#myNotesTab li").first().addClass("active");
    $("#myNotesTabContent div.tab-pane").first().addClass("active");
    if ( !$("#myNotesTabContent div.tab-pane").first().hasClass("in") ) {
        $("#myNotesTabContent div.tab-pane").first().addClass("in"); 
    }
    $("#frmAddNotes")[0].reset();
    $('#addnotes_note_unit_id').val($(this).attr("unitid"));
    $('#addnotes_unit_note_type').val($(this).attr("notestype"));
    $("#yourNotes").attr("unitid", $(this).attr("unitid"));
    $("#otherMemberNotes").attr("unitid", $(this).attr("unitid"));    
 });
 
 // for validating the add notes form
$( '#addnotes_unit_save' ).click( function( e ) {
    if ( $("#addnotes_unit_notes").val().length > 0) {
       $('#frmAddNotes').submit();
    } else {
        $('#notes-error-msg').show();
        $("#notes-error-msg").html('<h2><img src="' + base_url + 'public/images/login-error-icon.png">Please add notes!</h2>'); 
    }
    e.preventDefault();
    return false;
});

// submitting the add notes form
if($('#frmAddNotes').length) 
{
    $("#frmAddNotes").ajaxForm({
        beforeSubmit: function() {
            $('#notes-loading').removeClass('hide');
        },
        success: function(responseText, statusText, xhr, $form) {
            $('#notes-loading').addClass('hide');
            if (responseText == "success") {
                $('#notes-success-msg').show();
                $("#notes-success-msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Notes added successfully!</span></div>');
            } else {
                $('#notes-error-msg').show();
               $("#notes-error-msg").html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2> Error saving notes!</h2></div>');
            }
        },
        resetForm: true
    });
}

// fetch the user notes
$( "#yourNotes" ).click(function(){
  var unitId = $(this).attr("unitid");
  var userType = $(this).attr("userType");
  getUnitNotesByType(unitId, userType, "yourNotesDiv");
});

// fetch the other memeber notes
$( "#otherMemberNotes" ).click(function(){
  var unitId = $(this).attr("unitid");
  var userType = $(this).attr("userType");
  getUnitNotesByType(unitId, userType, "otherMemberNotesDiv");
});

function getUnitNotesByType(unitId, userType, divId) {
    $('#' + divId).html('');
    $('#' + divId).html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $.ajax({
        type: "POST",
        url: base_url + "getUnitNotes",
        data: {unitId: unitId, userType: userType},
        success: function(result) {
            $('#' + divId).html(result);
        }
    });
}

// to close notes dialog
$("#addnotes_unit_cancel").click(function(){
  $("#edivenceUnitModalNotes").modal( "toggle" ); 
});

// to change view icon
$("body").on("click", ".openViewIcon", function(){
   var c = $(this).hasClass("open");
    if (c == false) {
        $(this).addClass("open");
    } else {
        $(this).removeClass("open");
    }
});

$('body').on('click', '.loginUser', function(){
    $(location).attr('href', 'userLogin/' + this.id);
});

$("#searchNameUser").keyup(function() {
    pagenum = 1;
    loadDataIcon('currentList');
    loadUsersList('currentList',pagenum);
	//var key = event.which;
      //      if(key == 13)  // 
        //    {
          //  $('#searchNameUser').blur();
        //}
});

$("#searchUserFilter").click(function() {
    pagenum = 1;
    loadDataIcon('currentList');
    loadUsersList('currentList',pagenum);
});
function loadUsersList(divContent)
{
    searchName = $('#searchNameUser').val();
    userType = $('#userType').val();
    $.ajax({
        type: "POST",
        url: base_url + "searchUsersList",
        cache: false,
        data: {pagenum:pagenum, searchName: searchName, userType: userType},
        success: function(result) { 
            $('#' + divContent).html(result);
        }
    });
}

$(".delUser").click(function() {
    deluserId = this.id;
    delUserRole = $(this).attr("userRole");
});

$(".deleteUser").click(function() {
   $('.deleteuser_loader').show();
   $("#profile_suc_msg").hide();
   $("#err_msg").show();
    $.ajax({
        type: "POST",
        url: base_url + "deleteUser",
        data: {deluserId: deluserId, delUserRole: delUserRole},
        success: function(result) {
            $("#uclose").trigger("click");
            if (result == 0) {
                 $("#err_msg").html('<div class="gq-id-files-upload-error-text alert alert-danger" style="display: block;"><h2>This User cannot be deleted!</h2></div>');
            } else {
                $("#err_msg").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>User deleted successfully!</span></div>');
                $("#searchUserFilter").trigger("click");
            }
            $('.deleteuser_loader').hide();
        }
    });
});
function searchUsernames(id) {  
   $(id).autocomplete({
        source: function(request, response) {
            $.getJSON(base_url + "messages/usernamesbyRoles", {
                term: extractLast(request.term)
            }, response);

        },
        search: function() {
            var term = extractLast(this.value);
              if (term.length < 2) {
                return false;
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function(event, ui) {
            var terms = split(this.value);
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(" ");
            return false;
        }
    });
}
function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}
$("body").on("click", "#submittoassessor,#request-cc", function(){
	var userId = $("body #csUserId").val();
	var courseCode = $("body #csCourseCode").val();
	var courseStatus = $(this).data("coursestatus");
	$("body #status-message").show();
	$("body #status-message").html('<img src="' + base_url + 'public/images/loading.gif">');
	if (courseStatus !== "") {
		$.ajax({
			type: "POST",
			url: base_url + "updateCourseStatus",
			data: {courseStatus: courseStatus, courseCode: courseCode, userId: userId},
			success: function(responseText) {
				var result = jQuery.parseJSON(responseText);
				if(result.type == 'Error' ) {
					$("body #status-message").html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2><img src="' + base_url + 'public/images/login-error-icon.png"> '+ result.msg+'</h2></div>');   
					window.scrollTo(0, 0);
				} else if (result.type == 'Success') {
                                    if(courseStatus == '2'){ 
                                        $( "body #submittoassessor").hide( "slow"); 
                                        $(this).hide(); 
                                        $("body #courseStatus").val(courseStatus);  
                                    }
                                    if(courseStatus == '10'){ 
                                        $("body #courseStatus").val(courseStatus);  
                                        $("body #request-cc").prop("disabled", true ).addClass("disabled");
                                    }
                                    if(courseStatus == '12'){ 
                                        $("body .competency-call").hide( "slow"); 
                                        $("body #courseStatus").val(courseStatus);  
                                    }
                                    $("body #status-message").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span> '+ result.msg+'</span></div>');
									$('.body_section').scrollTop(0);
				}   
				if(result.code == '1'){
				  $("body #currentCourseStatus").val(courseStatus);  
				} else if(result.code != '5') {
                                    if ( $('#courseStatus option[value="' + $("#currentCourseStatus").val() + '"]').length > 0 ) {  
                                            $("#courseStatus").val($("#currentCourseStatus").val());
                                            $("#selectcourseStatus").html($('#courseStatus option[value="' + $("#currentCourseStatus").val() + '"]').html());
                                    } else {
                                            $("#courseStatus").val($("#courseStatus option:first").val());
                                            $("#selectcourseStatus").html($("#courseStatus option:first").html());                          
                                    }
				}
			}
		});
  } else {
	  $("body #status-message").html('<div class="gq-id-files-upload-error-text alert alert-danger"><img src="' + base_url + 'public/images/login-error-icon.png"> Please select status</div>');

  }
});
function searchUsersFromCourse(id, facVal, accVal, rtoVal, curuserId) {  
   $(id).autocomplete({
        source: function(request, response) {
			$.getJSON(base_url + "usersFromCourse", { term: extractLast(request.term), facId : facVal, accId : accVal, rtoId : rtoVal, curuserId : curuserId}, response);
        },
        search: function() {
            var term = extractLast(this.value);
              if (term.length < 2) {
                return false;
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function(event, ui) {
            var terms = split(this.value);
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
			$.ajax({
                type: "POST",
                url: base_url + "searchUsersListFrom",
                cache: false,
                data: {name:ui.item.value},
                success: function(result) { 
                    $("#UserId").val(result);
                }
            });
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(" ");
            return false;
        }
    });
}
/* Profile Update (from popup) -*/
$('#user_profile_form').on('submit', function(e) {
     if(validateAddress()){  
         $("#profile_suc_msg2").hide();
         $("#change_address_error").hide();
      //  e.preventDefault();
        form_data = $(this).serialize(); //Serializing the form data
           $.ajax({
                type: "POST",
                url: base_url+"updateprofileAjax",
                cache: false,
                data: form_data,
                success: function(result) {                   
                    $('#userprofile_firstname').css('cursor','not-allowed');
                    $("#change_address_error").hide();
		    $("#ajax-profile-error").hide();
		    $("#resume_msg").hide();
                    $("#profile_suc_msg2").show();
                    $("#profile_suc_msg2").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Profile updated successfully!</span></div>');
						$('.body_section,.profile_popup').scrollTop(0);
                },
            error: function(){
                $("#change_address_error").show();
                    $("#profile_suc_msg2").hide();
					$('.body_section,.profile_popup').scrollTop(0);
            }
                
            });
        }
       
   return false;
}); 

/**
 * Show or hide passowrd div
 * @param {int} type
 * @returns {undefined}
 */
function changePassowordDiv(type)
{
    if(type==1) // 1- show
    {
        $('.gq-id-files-upload-success-text').hide();
        $('.gq-id-pwd-error-text').hide();        
        $('#change_password_form').show();
        $('#user_profile_form').hide();
        $('#user_profile_form_div').hide();
        $('#matrixfileDiv').hide();
        $(".profile_popup").addClass("change_pwd");
        if($('#user_profile_form_manager'))
            $('#user_profile_form_manager').hide();
        $('#user_profile_form').hide();
        $('#change_address_error').hide();
        
    }
    else
    {
         $('.gq-id-files-upload-success-text').hide();
         $('.gq-id-pwd-error-text').hide();
         $('#password_oldpassword').val('');
         $('#password_newpassword').val('');
         $("#password_confirmnewpassword").val('');
         $('#change_password_form').hide();        
         $('#user_profile_form').show();
         if($('#user_profile_form_manager'))
            $('#user_profile_form_manager').show();
         $('#user_profile_form_div').show();
         $('#matrixfileDiv').show();
         $(".profile_popup").removeClass("change_pwd");
        
    }
}


/** Change password form **/
$('#change_password_form').on('submit', function(e) {

    e.preventDefault();
    form_data = $(this).serialize(); //Serializing the form data    
    $.ajax({
            type: "POST",
            url: base_url+"updatepasswordAjax",
            cache: false,
            data: form_data,
            success: function(result) {
			$("#pwd_error").hide();
               $('#current_password').val('');
                $('#password_newpassword').val('');
      $('#password_confirmnewpassword').val('');
                $("#profile_suc_msg2").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Password updated successfully!</span></div>');
                //$('#change_password_form').hide();
               // $('#user_profile_form').show();
               // $('#user_profile_form_div').show();
                
            }
       });
});
$(document).ready(function(){
    $('body').on('click', '.filter_tab', function(){
        var checkBoxSection = $(".check_box_section");
        if(checkBoxSection.hasClass('hide'))
            checkBoxSection.removeClass('hide').addClass('open');
        else
            checkBoxSection.removeClass('open').addClass('hide');
    });
    
});
$(document).ready(function(){
    $('body').on('touchstart', '.sort_tab', function(){
        var checkBoxSection = $(".check_box_section");
        var titlesBlockSection = $(".titles_block_mobile");
//        if(checkBoxSection.hasClass('open'))
//            checkBoxSection.removeClass('open').addClass('hide');
            
        if(titlesBlockSection.hasClass('hide'))
            titlesBlockSection.removeClass('hide').addClass('open');
        else
            titlesBlockSection.removeClass('open').addClass('hide');
    });
});

function queryParameters () {
    var result = {};
    var params = window.location.search.split(/\?|\&/);
    params.forEach( function(it) {
        if (it) {
            var param = it.split("=");
            result[param[0]] = param[1];
        }
    });
    return result;
}
if($('body #evidencefiles').length > 0) {
        $('.evidences-empty').hide();
	$.extend( $.fn.dataTable.defaults, {
            ordering:  true
        });
	var oTable = $('body #evidencefiles').DataTable({
			"pagingType": "simple",
                        "order": []
                    });
                    
         setFacetingFilterCount(oTable, 'default');                    

	$.fn.dataTableExt.afnFiltering.push(
	  function(oSettings, aData, iDataIndex) {
                var parent_match = 0;
                $('#evidence-filter input[type="checkbox"].parent-filter:checked').each(function(index,value){
                    var val =$(this).val().toLowerCase();
                    for (var col=0; col<aData.length; col++) {
                            if (aData[col].toLowerCase().indexOf(val)>-1) {
                                    parent_match++;
                                    break;
                            }
			}
                }); 
                if(parent_match == 0 ) return false;
		var totalLength = $('#evidence-filter input[type="checkbox"].children-filter:not(".parent-filter")').length;
		var checkedLength = $('#evidence-filter input[type="checkbox"].children-filter:checked').not(".parent-filter").length;
		var filterArray = [];
		if(totalLength != checkedLength) {
			$('#evidence-filter input[type="checkbox"].children-filter:checked').not(".parent-filter").each(function(index,value){
				filterArray.push($(this).val());
			});
		}
		var keywords = filterArray;
		var matches = 0;
		for (var k=0; k<keywords.length; k++) {
			var keyword = keywords[k].toLowerCase();
			for (var col=0; col<aData.length; col++) {
				if (aData[col].toLowerCase().indexOf(keyword)>-1) {
					matches++;
					break;
				}
			}
		}

                if((matches == 0 && keywords.length > 0) || (checkedLength == 0)) return false;
                var totalLength = $('#evidence-filter input[type="checkbox"]:not(".parent-filter,.children-filter")').length;
		var checkedLength = $('#evidence-filter input[type="checkbox"]:checked').not(".parent-filter,.children-filter").length;
		var filterArray = [];
		if(totalLength != checkedLength) {
			$('#evidence-filter input[type="checkbox"]:checked').not(".parent-filter,.children-filter").each(function(index,value){
				filterArray.push($(this).val());
			});
		}
		var keywords = filterArray;
		var matches = 0;
		for (var k=0; k<keywords.length; k++) {
			var keyword = keywords[k].toLowerCase();
			for (var col=0; col<aData.length; col++) {
				if (aData[col].toLowerCase().indexOf(keyword)>-1) {
					matches++;
					break;
				}
			}
		}

                var searchString = $(".dataTables_filter input").val().toLowerCase();  
		var searchMatches = 0;
		for (var col=0; col<aData.length; col++) {
		    if (aData[col].toLowerCase().indexOf(searchString)>-1) {
				searchMatches++;
				break;
			
			}
		}
		if(searchMatches>0 && (matches > 0 || keywords.length==0) && (checkedLength > 0)) return true;
		  return false;
		}		
	);

} else {
    $('#evidence-total, .image-count, .audio-count, .video-count, .text-count, .file-count, .unmapped-unit, .mapped-one, .mapped-two').html('0');
    $('.evidences-empty').show();
}

/* CAND*/


if($('#evidence').length>0) {

	$.extend( $.fn.dataTable.defaults, {
            ordering:  true
        });
	var oTable = $('body #evidence').DataTable({
			"pagingType": "simple",
                        "order": []
		});

        setFacetingFilterCount(oTable, 'default');

	$.fn.dataTableExt.afnFiltering.push(
	  function(oSettings, aData, iDataIndex) {
		var totalLength = $('#evidence-filter input[type="checkbox"].children-filter').length;
		var checkedLength = $('#evidence-filter input[type="checkbox"].children-filter:checked').length;

		var filterArray = [];
		if(totalLength != checkedLength) {
			$('#evidence-filter input[type="checkbox"].children-filter:checked').each(function(index,value){
				filterArray.push($(this).val());
			});
		}
		var keywords = filterArray;
		var matches = 0;
		for (var k=0; k<keywords.length; k++) {
			var keyword = keywords[k].toLowerCase();
			for (var col=0; col<aData.length; col++) {
				if (aData[col].toLowerCase().indexOf(keyword)>-1) {
					matches++;
					break;
				}
			}
		}
                if((matches == 0 && keywords.length > 0) || (checkedLength == 0)) return false;
                var totalLength = $('#evidence-filter input[type="checkbox"]:not(".children-filter")').length;
		var checkedLength = $('#evidence-filter input[type="checkbox"]:checked').not(".children-filter").length;
		var filterArray = [];
		if(totalLength != checkedLength) {
			$('#evidence-filter input[type="checkbox"]:checked').not(".children-filter").each(function(index,value){
				filterArray.push($(this).val());
			});
		}
		var keywords = filterArray;
		var matches = 0;
		for (var k=0; k<keywords.length; k++) {
			var keyword = keywords[k].toLowerCase();
			for (var col=0; col<aData.length; col++) {
				if (aData[col].toLowerCase().indexOf(keyword)>-1) {
					matches++;
					break;
				}
			}
		}
                var searchString = $(".dataTables_filter input").val().toLowerCase();
		var searchMatches = 0;
		for (var col=0; col<aData.length; col++) {
		    if (aData[col].toLowerCase().indexOf(searchString)>-1) {
				searchMatches++;
				break;
			
			}
		}
		if(searchMatches>0 && (matches > 0 || keywords.length==0) && (checkedLength > 0)) return true;
		  return false;
		}
	);
}

if($('#evidence').length>0) {
    $('document').ready(function(){
        $('.fdate').trigger('click');
        $('.fdate').trigger('click');
    });
}

$('body').on('keyup', '.namesearch', function(){
    oTable.search($(this).val()).draw();
    setFacetingFilterCount(oTable, 'filter');
});
$('#evidence-filter').on('click','input[type="checkbox"]',function(){
    oTable.search($('.namesearch').val()).draw();
    setFacetingFilterCount(oTable, 'filter');    
});

function setFacetingFilterCount (oTable, filter){
        if(filter == 'default'){
            rowsCount = oTable.rows().count();
            imageCount = oTable.rows('.image').count();
            audioCount = oTable.rows('.audio').count();
            videoCount = oTable.rows('.video').count();
            textCount = oTable.rows('.text').count();
            fileCount = oTable.rows('.file').count();
            unmappedCount = oTable.rows('.mapped0').count();
            mapped1Count = oTable.rows('.mapped1').count();
            mapped2Count = oTable.rows('.mapped2').count();
        } else {
            rowsCount = oTable.rows().count();
            imageCount =  oTable.rows('.image', { filter : 'applied'} ).nodes().length;
            audioCount =  oTable.rows('.audio', { filter : 'applied'} ).nodes().length;
            videoCount =  oTable.rows('.video', { filter : 'applied'} ).nodes().length;
            textCount =  oTable.rows('.text', { filter : 'applied'} ).nodes().length;
            fileCount =  oTable.rows('.file', { filter : 'applied'} ).nodes().length;
            unmappedCount =  oTable.rows('.mapped0', { filter : 'applied'} ).nodes().length;
            mapped1Count =  oTable.rows('.mapped1', { filter : 'applied'} ).nodes().length;
            mapped2Count =  oTable.rows('.mapped2', { filter : 'applied'} ).nodes().length;
        }
        $('#evidence-total').html(rowsCount);
        $('.image-count').html(imageCount);
        $('.audio-count').html(audioCount);
        $('.video-count').html(videoCount);
        $('.text-count').html(textCount);
        $('.file-count').html(fileCount);
        $('.unmapped-unit').html(unmappedCount);
        $('.mapped-one').html(mapped1Count);
        $('.mapped-two').html(mapped2Count);
}


$('body').on('click', '.sort_section', function(){
    var sortbyclass = $(this).attr('data-orderby')
    var currentArrow = $('.f'+sortbyclass+' i').html();
    $('.sorting li span i').css('visibility','hidden');
    $('.sorting li span').removeClass('bold');
    $('.sorting li span.f'+sortbyclass).addClass('bold');
    $('.sorting li span.f'+sortbyclass+' i').css('visibility','visible').addClass('bold');
    newArrow = (currentArrow == 'arrow_downward') ? 'arrow_upward' : 'arrow_downward';
    $('.f'+sortbyclass+' i').html(newArrow);
    $('.sortby'+sortbyclass).trigger("click");
});
$('body').on('click', '.fac_view_evidence', function(){
    var evdId = $(this).attr('data-evidenceid');
    var evidenceItem = $(this).parent().parent().parent();
    $.ajax({
        type: "POST",
        url: base_url+"changeEvidenceViewStaus",
        cache: false,
        data: {evidenceId: evdId},
        success: function(result) {
            evidenceItem.addClass('disable');
            onloadEvidenceCount();
        }
    });
});

/* Change Password Validations */
function passwordShowerrorMsg(errorMsg,msgId)
{
    var startdiv = '<div class="gq-id-pwd-error-text1 alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    $("#pwd_error1").show();
    $("#pwd_error1").html(startdiv + errorMsg + enddiv);
    if($("#"+msgId).val() != "")
        $("#"+msgId).val('');
    $("#"+msgId).focus();
}
function newPasswordUpdate()
{
    var displayConfirmPwd = $("#confirm-password").parent().css( "display" );  
    var newpwd = $("#new-password").val();
    var newconfirmpwd = $("#confirm-password").val();
    var startdiv = '<div class="gq-id-pwd-error-text1 alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
   
      
    if (newpwd == "") {
        passwordShowerrorMsg("Please enter New Password", "new-password");
        return false;
    }
    if (newpwd != "") {
        if (newpwd.length < 8) {
            passwordShowerrorMsg("New Password must be minimum of 8 characters", "new-password");
            return false;
        }
    }
    if (newpwd != "") {
        if (newpwd.length > 16 ) {
            passwordShowerrorMsg("New Password must be maximum of 16 characters", "new-password");
            return false;
        }
    }
    if (newpwd != "") {
        if (!(/[0-9]/.test(newpwd) && /[a-zA-Z]/.test(newpwd))) {    // Password should contain atleast one letter and one number
            passwordShowerrorMsg("Password should contain atleast one letter and one digit", "new-password");
            return false;
        }
    }
  
    
    return true;
}

//Check confirm password

function checkConfirmPassword()
{
    var newpwd = $("#new-password").val();
    var newconfirmpwd = $("#confirm-password").val();
    var displayConfirmPwd = $("#confirm-password").parent().css( "display" ); 
    
     if (newconfirmpwd == "" && displayConfirmPwd != 'none') {
        passwordShowerrorMsg("Please enter Confirm Password", "confirm-password");
        return false;
    }
    if (newpwd != "" && newconfirmpwd != "" ) {        
        if (newpwd != newconfirmpwd)
        {
            passwordShowerrorMsg("New Password and Confirm Password does not match", "confirm-password");
            return false;
        }
    } 
   $('#change_pswd_icon').show();
   return true;
}
// On change of new password field icons
function chnageMaterialIcon()
{
   
        if (newPasswordUpdate())
        {
            $('#new_pswd_icon').show();
            
        }
        else
        {
            $('#change_pswd_icon').hide();
            $('#new_pswd_icon').hide();
        }
    
}

/* Password Update (from New User) -*/
$('#updatePassword').on('submit', function(e) {   
     if(newPasswordUpdate() && checkConfirmPassword()){  
        e.preventDefault();
        form_data = $(this).serialize(); //Serializing the form data
           $.ajax({
                type: "POST",
                url: "updateNewPasswordAjax",
                cache: false,
                data: form_data,
                success: function(result) {
                    $("#profile_suc_msg3").show();
                    $("#profile_suc_msg3").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>Profile updated successfully!</span></div>');                    
                   window.location.href = base_url+'userprofile';
                  
                }
            });
        }
       
   return false;
});
/* Password Update (from New User) -*/
$('#newUserupdatePassword').on('submit', function(e) {
     if(newPasswordUpdate() && checkConfirmPassword()){ 
        e.preventDefault();
        form_data = $(this).serialize(); //Serializing the form data
           $.ajax({
                type: "POST",
                url: base_url+"updateNewUserPasswordAjax",
                cache: false,
                data: {pwd:$('#new-password').val(),tokenid:$('#hdn_login_token').val()},
                success: function(result) { 
                    if(result == 0) {
                        $("#profile_suc_msg3").show();
                        $("#profile_suc_msg3").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><h2>Invalid User!</h2></div>');                         
                    } else  {
                        $("#profile_suc_msg3").show();
                        $("#profile_suc_msg3").html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><h2>Password updated successfully!</h2></div>'); 
                        var data = result.split('@'); 
                        if(data[1] == 2)
                        {  
                            $("#InputPassword1").val($('#new-password').val());
                            $("#onboard2").removeClass("hidden");
                            $('#onboard2').modal({backdrop: 'static', keyboard: false,show:true});                            
                            $("#newUserupdatePassword").addClass("hidden");
                        }
                    }
                  
                }
            });
        }
       
   return false;
});
function saveUserPassword(){       
           $.ajax({
                type: "POST",
                url: "updateNewUserAjax",
                cache: false,                
                success: function(result) {
                   window.location.href = base_url+'userprofile';
                }
            });
      
       
   return false;
}


//$("#ok_got_it").click(function() {
//    saveNewUserPassword();
//    $('#frmLogin').submit();
//});

function saveNewUserPassword() {
    
    $.ajax({
        type: "POST",
        url: base_url + "updateNewUserAjaxStatus",
        cache: false,
        data: {tokenid: $('#hdn_login_token').val()},
        success: function(result) {
          $('#frmLogin').submit();
        }
    });


    return false;
}

$('body').on('click', '.existing-evidence-filter', function(){
        thisValue = $(this).val();
        if($(this).attr('checked')){
            $(this).removeAttr('checked');
            $('.file_info_block .type-'+thisValue).addClass('hide').removeClass('open');
        } else {
            $(this).attr('checked', 'checked');
            $('.file_info_block .type-'+thisValue).addClass('open').removeClass('hide');
        }
});
$('body').on('click', '.userprofile,#mobileQualification', function(){
    var courseCode = $(this).attr("data-courseCode");
    var userId = $(this).attr("data-userId");
    getApplicantDetails(courseCode, userId);
    $('.portfolio-container').hide();
    $('ul.nav').addClass('hide');
});
function addDTPickerBehaviour(){
 $('.date_field').each(function(){
        $(this).datetimepicker({
            controlType: 'select',
            oneLine: true,
            timeFormat: 'hh:mm tt',
            dateFormat: 'dd/mm/yy',
            minDate: 'today'
        });
        $("#ui-datepicker-div").click(function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
    });
}
function getApplicantDetails(courseCode, userId){
    $('#removeCandidate').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $('.candidate-details').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $.ajax({
        type: "POST",
        url: base_url + 'applicantDetails/' + courseCode +'/'+ userId +'',
        cache: false,
        success: function(result) {
            $(".candidate-details").html(result).addClass('padding-bottom');
            addDTPickerBehaviour();
        }
    });
}
$('body').on('click', '.closeDivTag', function(){
    $('.candidate-details').addClass('hide');
    $('.portfolio-container').addClass('show');
    window.location.href = base_url + "applicants";
});
$('body').on('click', '#mobileFiles', function(){
    var courseCode = $(this).attr("data-courseCode");
    var userId = $(this).attr("data-userId");
    getFilesDetails(courseCode, userId);
    $('.portfolio-container').hide();
    $('ul.nav').addClass('hide');
});
function getFilesDetails(courseCode, userId){
    $('#removeCandidate').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $('.candidate-details').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $.ajax({
        type: "POST",
        url: base_url + 'rolewiseFiles/' + courseCode +'/'+ userId +'',
        cache: false,
        success: function(result) {
            $(".candidate-details").html(result).addClass('padding-bottom');
        }
    });
}
$('body').on('click', '#mobileCanProfile', function(){
    var courseCode = $(this).attr("data-courseCode");
    var userId = $(this).attr("data-userId");
    getCandidateDetails(courseCode, userId);
    $('.portfolio-container').hide();
    $('ul.nav').addClass('hide');   
});
function getCandidateDetails(courseCode, userId){
    $('#removeCandidate').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $('.candidate-details').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $.ajax({
        type: "POST",
        url: base_url + 'candidateProfile/' + courseCode +'/'+ userId +'',
        cache: false,
        success: function(result) {
            $(".candidate-details").html(result).addClass('padding-bottom');
        }
    });
}
$('body').on('click', '.mobileUnitInfo', function(){
    var courseCode = $(this).attr("data-courseCode");
    var unitCode = $(this).attr("data-unitCode");
    var userId = $(this).attr("data-userId");
    getUnitDetailsInfo(courseCode, unitCode, userId);
    $('.portfolio-container').hide();
    $('.candidate-details').hide();
    $('ul.nav').addClass('hide');      
});
function getUnitDetailsInfo(courseCode, unitCode, userId){
    $('#removeUnitInfo').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $('.unitInfo-details').html('<div class="notes-loading-icon"><img src="' + base_url + 'public/images/loading.gif" /></div>');
    $.ajax({
        type: "POST",
        url: base_url + 'courseunitDetails/' + courseCode +'/'+ unitCode +'/'+ userId +'',
        cache: false,
        success: function(result) {
            $(".unitInfo-details").html(result).addClass('padding-bottom');
            addDTPickerBehaviour();
        }
    });
}
$('body').on('click', 'p.mobileUnitInfoElements', function(){
    $(this).parents('.container').find('#accordion1').slideToggle();
    return false;
});

$('body').on('click', '#mobileQualForReload', function(){
    var courseCode = $(this).attr("data-courseCode");
    var userId = $(this).attr("data-userId");
    window.location.href = base_url + "applicants?page=Params&ccode="+courseCode+"&uid="+userId+"";
});
function getReload(courseCode, userId){
    getApplicantDetails(courseCode, userId);
    $('.portfolio-container').hide();
    $('ul.nav').addClass('hide');
}

$('body').on('click', '#mobileCanForReload', function(){
    var courseCode = $(this).attr("data-courseCode");
    var userId = $(this).attr("data-userId");
    window.location.href = base_url + "applicants?page=candidate&ccode="+courseCode+"&uid="+userId+"";
});
function getReloadForCanProfile(courseCode, userId){
    getCandidateDetails(courseCode, userId);
    $('.portfolio-container').hide();
    $('ul.nav').addClass('hide');  
}
$(window).load(function(){
    var Params = queryParameters();
    if (Params.page=='Params') {
        setTimeout(getReload(queryParameters().ccode, queryParameters().uid),10000);
    }  
    if (Params.page=='candidate') {
        setTimeout(getReloadForCanProfile(queryParameters().ccode, queryParameters().uid),10000);
    }  
})
$('body').on('click', '.btn-back', function(){
    $('.unitInfo-details').hide();
    $('.portfolio-container').hide();
    var courseCode = $(this).attr("data-courseCode");
    var userId = $(this).attr("data-userId");
    window.location.href = base_url + "applicants?page=Params&ccode="+courseCode+"&uid="+userId+"";
//    $('.candidate-details').show();
})
$('#closeMyModal').click(function(){
    var uploadactval = $('#uploadaction').val();
    if(uploadactval != 'undefined' && uploadactval > 0)
        location.reload();       
});
/*Facilitator Update in Manager Portfolio */
function updateFacilitator(courseCode , userId, listId,userEmail,courseName)
{   
    var facBtn = $('.update_fac_btn');
    
    //
    facVal = $('#fac_'+listId).val();  
	if(facVal == 0)
	{
            $("#pwd_error_"+listId).show();
	$("#profile_suc_msg2_"+listId).hide();		
        $("#pwd_error_"+listId).html('<div class="gq-id-pwd-error-text alert alert-danger" style="display: block;"><h2>Please Select Account Manager</h2></div>');
	}
    if(facVal != 0)
    {
     facBtn.text("Saving..");
    facBtn.attr('disabled', true);
    $("#pwd_error_"+listId).hide();
    $("#profile_suc_msg2_"+listId).hide();
        $.ajax({
            type: "POST",
            url: "updateFacilitator",
            cache: false,
            data: {listId:listId,facilitator:facVal,userEmail:userEmail,userId:userId,courseCode:courseCode,courseName:courseName},
            success: function(result) {
                var res = jQuery.parseJSON(result);
                if(res.status=='true')
                {
                    $('#fac_is_update').val('1');
		    $("#pwd_error_"+listId).hide();
                    $("#profile_suc_msg2_"+listId).show();
                     $("#profile_suc_msg2_"+listId).html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>'+res.message+'</span></div>');
                     facBtn.attr('disabled', false);
                     facBtn.text("UPDATE");
                     window.location.reload();
                }
            },
            error: function(){
                facBtn.attr('disabled', false);
            }
       });
       return false;
   }
   else
   {
       return false;
   }
   
}
/*Assessor Update in Manager Portfolio */
function updateAssessor(courseCode , userId, listId)
{
    var facBtn = $('.update_ass_btn');
   
    var assVal = $('#ass_'+listId).val();
    $("#profile_suc_msg3_"+listId).hide();
	if(assVal == 0)
	{
        $("#pwd_error2_"+listId).show();
	$("#profile_suc_msg3_"+listId).hide();		
        $("#pwd_error2_"+listId).html('<div class="gq-id-pwd-error-text alert alert-danger" style="display: block;"><h2>Please Select Assessor</h2></div>');
	}
    
    if(assVal != 0)
    {
		 facBtn.text("Saving..");
        facBtn.attr('disabled', true);
        $("#pwd_error2_"+listId).hide();
        $("#profile_suc_msg3_"+listId).hide();
        $.ajax({
            type: "POST",
            url: "updateAssessor",
            cache: false,
            data: {listId:listId,assessor:assVal},
            success: function(result) {
                var res = jQuery.parseJSON(result);
                if(res.status=='true')
                {
                    $('#ass_is_update').val('1');
                    $("#pwd_error2_"+listId).hide();
                    $("#profile_suc_msg3_"+listId).show();
                     $("#profile_suc_msg3_"+listId).html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>'+res.message+'</span></div>');
                      facBtn.attr('disabled', false);
                      facBtn.text("UPDATE");
                      window.location.reload();
                }
                
            },
            error: function(){
                facBtn.attr('disabled', false);
            }
       });
       
       return false;
   }
   else
   {
       return false;
   }
}
/*Assessor Update in Manager Portfolio */
function updateRto(courseCode , userId, listId)
{
    var facBtn = $('.update_rto_btn');    
    
    rtoVal = $('#rto_'+listId).val();
	if(rtoVal == 0)
	{
                $("#pwd_error3_"+listId).show();
		$("#profile_suc_msg4_"+listId).hide();		
                $("#pwd_error3_"+listId).html('<div class="gq-id-pwd-error-text alert alert-danger" style="display: block;"><h2>Please Select RTO</h2></div>');
	}
    if(rtoVal != 0)
    {
	facBtn.text("Saving..");
        facBtn.attr('disabled', true);
        $("#pwd_error3_"+listId).hide();
        $("#profile_suc_msg4_"+listId).hide();
        $.ajax({
            type: "POST",
            url: "updateRto",
            cache: false,
            data: {listId:listId,rto:rtoVal},
            success: function(result) {
                var res = jQuery.parseJSON(result);
                $('#rto_is_update').val('1');
                if(res.status=='true')
                {
                   
                    $("#pwd_error3_"+listId).hide();
                    $("#profile_suc_msg4_"+listId).show();
                     $("#profile_suc_msg4_"+listId).html('<div class="gq-id-files-upload-success-text alert alert-success" style="display: block;"><span>'+res.message+'</span></div>');
                     facBtn.attr('disabled', false);
                     facBtn.text("UPDATE");
                     window.location.reload();
                }
                
            },
            error: function(){
                facBtn.attr('disabled', false);
            }
       });
       
       return false;
       }
   else
   {
       return false;
   }
}
if( $('.view-message').length > 0){   
    $('header,.mobi-profile').addClass('hide');
    $('#compose_message').focus();
    }
if($('.mobi_unit_detail').length > 0)
{
    var unitDetail =  $('#unit-code').val();
    $('.mobi-profile').addClass('hide');
    $('nav').hide();
    $('.info-header').toggleClass('show hide');
    $('.portfolio').hide();
    $('.unit-info').html('<div class="unit-info"><a href="/qualifications"><i class="material-icons btn-back">arrow_back</i></a><strong class="title">Unit '+unitDetail+'</strong></div>');
    
}
if($('.mobile_new_message_section').length > 0){   
    $('header,.mobi-profile,#noMessages').addClass('hide');
    
    }
function checkEvidenceToUnitSubmit(userId, courseCode, unitCode)
{
    var selfAssNotes = $('#selfassnote').val();  
    var evdcount = $('.evdcount').attr('data-evdcount');    
    if (evdcount == 0 || evdcount == "0" || selfAssNotes == "" ) {
        $('#btn-submit').attr({"data-toggle":"modal", "data-target":"#review-submit"});
    }
    else if(evdcount != "" && evdcount != "undefined" && selfAssNotes != "" && selfAssNotes.split(' ').length < 50){
        $('#btn-submit').removeAttr("data-toggle","data-target");
        $('#btn-submit').attr({"data-toggle":"modal", "data-target":"#min-words-count"});   
             
    }
     else   
     {
         $('#btn-submit').removeAttr("data-toggle","data-target");
         $.ajax({
        type: "POST",
        url: base_url + "submitUnitForReview",
        data: {unitId: unitCode, courseCode: courseCode, userId: userId, selfAssNotes:selfAssNotes},
        success: function(result) {
             var rec = result.split("&&");  
             console
            if (rec[0] == '0') {
                //$('#gq-dashboard-tabs-error-assess').html('<h2>Assessment not submitted!</h2>');
            } else if (rec[0] == '1') {             
                $('#btn-submit').attr({"data-toggle":"modal", "data-target":"#suceess-msg"});
                 $('#suceess-msg').modal('show');                
            }
            else if (rec[0] == '2') {
                //$('#gq-dashboard-tabs-error-assess').html('<h2>Please Upload Evidences</h2>');
            }
            else if (rec[0] == '3') {
                //$('#gq-dashboard-tabs-error-assess').html('<h2>Please Enter Self Assessment Notes</h2>');
            }
           // setTimeout(function(){jQuery("#evd_close_assess").trigger('click');},3000);
        }
        });
    }
}

//Mobile Version Change Password
function checkCurrentRolePassword(){
    mypassword = $('#current_password').val();
    $("#hdn_pwd_check").val("0");
    var startdiv = '<div class="gq-id-pwd-error-text alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    var mypassword = mypassword;
    $("#pwd_error").html('');
    $("#pwd_error").show();
    //$("#pwd_error").html(startdiv + 'Please wait till password gets validated' + enddiv);
    if(mypassword!="") {        
        $.ajax({
            type: "POST",
            url: "checkMyPassword",
            cache: false,
            data: {mypassword: mypassword},
            success: function(response) {
                result = JSON.parse(response)       
                $('#change_pwd_error').show();              
                if (result.status == "fail") {
                    $("#hdn_pwd_check").val("0");
                    $("#pwd_error").html(startdiv + 'Current Password is not correct' + enddiv).delay(3000).fadeOut(100);
                    $("#password_hdnoldpassword").val('');
                    $("#password_hdnoldpassword").focus();
                    return false;
                }
                else if (result.status == "success") {
                val = $("#password_hdnoldpassword").val;
                $("#password_oldpassword").val=val;
                $("#idfiles").addClass("hidden-xs");
                $("#profileinfo").addClass("hidden-xs");
                $(".currentpassword").addClass("hidden-xs");
                $(".chngpwddiv").removeClass("hidden-xs");
                }
            }
        });
    }
    else
    {
        $("#pwd_error").html(startdiv + 'Please enter current password' + enddiv).delay(3000).fadeOut(100);
    }
}
   $(".change_link ").click(function(){
       $('#pwd_error').hide();
        $("#idfiles").addClass("hidden-xs");
        $(".profileinfo").addClass("hidden-xs");
        $(".currentpassword").removeClass("hidden-xs");
        $(".header-border").addClass("hidden-xs");
        $(".mobi-profile").addClass("hidden-xs");
		$("#change_file_error").hide();
    });
    $(".currpwdnext").click(function(){ 
         var curpwd = $("#password_hdnoldpassword").val(); 
        var oldpwd = $("#password_oldpassword").val();
         if(curpwd!="")
            oldpwd = curpwd;
        var displayOldPwd = $("#password_oldpassword").parent().css( "display" );        
        var displayConfirmPwd = $("#password_confirmnewpassword").parent().css( "display" );        
        var hdnpwdchk = $("#hdn_pwd_check").val();
       
        
        if (curpwd == "" && displayOldPwd != 'none') {
            passwordShowMsg("Please enter Current Password", "password_oldpassword");
            return false;
        }
        else if (curpwd != "" && hdnpwdchk == 0) {
                checkCurrentRolePassword($("#password_hdnoldpassword").val());
                return false;            
        }
        else{
            $("#password_hdnoldpassword").val(curpwd);
            $("#idfiles").addClass("hidden-xs");
            $(".profileinfo").addClass("hidden-xs");
            $(".currentpassword").addClass("hidden-xs");
            $(".chngpwddiv").removeClass("hidden-xs");
        }
    });
    $(".chngpwdval").click(function(){ 
        $('#mbl_pwd_error').html('');
        var curpwd = $("#password_hdnoldpassword").val(); 
        var displayConfirmPwd = $("#password_confirmnewpassword").parent().css( "display" );        
        var newpwd = $("#password_newpassword").val();
        var newconfirmpwd = $("#password_confirmnewpassword").val();
        if (newpwd == "") {
        $('#mbl_pwd_error').html("Please enter New Password");
        passwordShowMsg("Please enter New Password", "password_newpassword");
        return false;
        }
        if (newpwd != "") {
            if (newpwd.length < 8) {
                $('#mbl_pwd_error').html("New Password must be minimum of 8 characters");
                passwordShowMsg("New Password must be minimum of 8 characters", "password_newpassword");
                return false;
            }
        }
        if (newconfirmpwd == "") {
            $('#mbl_pwd_error').html("Please enter Confirm Password");
            passwordShowMsg("Please enter Confirm Password", "password_confirmnewpassword");
            return false;
        }
        if (newconfirmpwd != "" && displayConfirmPwd != 'none') {
             
            if (newconfirmpwd.length < 8) {
                $('#mbl_pwd_error').html("New Confirm Password must be minimum of 8 characters");
                passwordShowMsg("New Confirm Password must be minimum of 8 characters", "password_confirmnewpassword");
                return false;
            }
        }
        if (newpwd != "" && newconfirmpwd != "") {
            if (curpwd == newpwd) {
                $('#mbl_pwd_error').html("Current Password and New Password must be different");
                passwordShowMsg("Current Password and New Password must be different", "password_newpassword");
                $("#password_confirmnewpassword").val('');
                return false;
            }
            if (newpwd != newconfirmpwd)
            {
                 $('#mbl_pwd_error').html("New Password and Confirm Password does not match");
                passwordShowMsg("New Password and Confirm Password does not match", "password_confirmnewpassword");
                return false;
            }            
         $.ajax({
            type: "POST",
            url: base_url+"updatepasswordAjax",
            cache: false,
            data: {password_newpassword:newpwd},
            success: function(result) {
                $('#current_password').val('');
                 $('#password_newpassword').val('');
      $('#password_confirmnewpassword').val('');
              $("#idfiles").addClass("hidden-xs");
            $(".profileinfo").addClass("hidden-xs");
            $(".currentpassword").addClass("hidden-xs");
            $(".chngpwddiv").addClass("hidden-xs");
            $(".pwdsucc").removeClass("hidden-xs");
                
            }
       });
         
        } 
    });
$("#password_save").click(function()
{
    var displayOldPwd = $("#password_oldpassword").parent().css( "display" );
    var displayConfirmPwd = $("#password_confirmnewpassword").parent().css( "display" );
      var hdnpass = $("#password_hdnoldpassword").val();           
    var curpwd = $("#password_oldpassword").val();
//     if(curpwd == "" )
//         curpwd = hdnpass;
    
    var newpwd = $("#password_newpassword").val();
    var newconfirmpwd = $("#password_confirmnewpassword").val();
    var startdiv = '<div class="gq-id-pwd-error-text alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    var hdnpwdchk = $("#hdn_pwd_check").val();
    
    if (curpwd == "" && displayOldPwd != 'none') {
        passwordShowMsg("Please enter Current Password", "password_oldpassword");
        return false;
    }
    if (curpwd != "") {
          pswd_validation = checkCurrentPassword($("#password_oldpassword").val());
        if(pswd_validation=='fail')
        {
            passwordShowMsg("Current password does not match", "password_oldpassword");
            return false;
        }
    }
    if (newpwd == "") {
        passwordShowMsg("Please enter New Password", "password_newpassword");
        return false;
    }
    if (newpwd != "") {
        if (newpwd.length < 8) {
            passwordShowMsg("New Password must be minimum of 8 characters", "new-password");
            return false;
        }
    }
    if (newpwd != "") {
        if (newpwd.length > 16 ) {
            passwordShowMsg("New Password must be maximum of 16 characters", "new-password");
            return false;
        }
    }
    if (newpwd != "") {
        if (!(/\d/.test(newpwd) && /[a-zA-Z]/.test(newpwd))) {    // Password should contain atleast one letter and one number
            passwordShowMsg("Password should contain atleast one letter and one digit", "new-password");
            return false;
        }
    }
    if (newconfirmpwd == "" && displayConfirmPwd != 'none') {
        passwordShowMsg("Please enter Confirm Password", "password_confirmnewpassword");
        return false;
    }
    if (newconfirmpwd != "") {
        if (newpwd.length < 8) {
            passwordShowMsg("New Password must be minimum of 8 characters", "new-password");
            return false;
        }
    }
    if (newconfirmpwd != "") {
        if (newpwd.length > 16 ) {
            passwordShowMsg("New Password must be maximum of 16 characters", "new-password");
            return false;
        }
    }
    if (newconfirmpwd != "") {
        if (!(/\d/.test(newpwd) && /[a-zA-Z]/.test(newpwd))) {    // Password should contain atleast one letter and one number
            passwordShowMsg("Password should contain atleast one letter and one digit", "new-password");
            return false;
        }
    }
    if (newpwd != "" && newconfirmpwd != "" && displayOldPwd != 'none') {
        if (curpwd == newpwd) {
            passwordShowMsg("Current Password and New Password must be different", "password_newpassword");
            $("#password_confirmnewpassword").val('');
            return false;
        }
        if (newpwd != newconfirmpwd)
        {
            passwordShowMsg("New Password and Confirm Password does not match", "password_confirmnewpassword");
            return false;
        }
    }
    
});
$('.clear_pswd_div').click(function()
{
            $("#idfiles").removeClass("hidden-xs");
            $(".profileinfo").removeClass("hidden-xs");
            $(".currentpassword").addClass("hidden-xs");
            $(".chngpwddiv").addClass("hidden-xs");
            $(".pwdsucc").addClass("hidden-xs");
            $(".header-border").removeClass("hidden-xs");
            $(".mobi-profile").removeClass("hidden-xs");
});

/** Disabling first space on key enter while adding messages **/
$('body').on('keydown', '#compose_message , #compose_subject', function(e) {
    //console.log(this.value);
    if (e.which === 32 &&  e.target.selectionStart === 0) {
      return false;
    }  
  });
/* To handle Change PAssword POPUP*/
function passwordCancel()
{
    $('.gq-id-pwd-error-text').hide();
    $('#password_oldpassword').val('');
     $('#password_newpassword').val('');
     $("#password_confirmnewpassword").val('');
     $('#change_pwd_popup').modal('hide');  
}

$('body').on('click', '.reminder-view', function(){
    var remId = $(this).attr('data-reminderId');
    var remViewStatus = $(this).attr('data-status');
    var currentElement = $(this);
    if(remViewStatus == '0'){
        $.ajax({
            type: "POST",
            url: base_url + "changeReminderViewStatus",
            data: {reminderId: remId },
            success: function(result) {
                currentElement.find('.content').removeClass('bold');
                //console.log(result);
                //return false;
            }
        });
    }
});
/*to handle Checkbox Cancel button */
function cancelCheckbox()
{
    var ckbox = $('#span_'+$('#unitcheckval').val());
    if (ckbox.is(':checked')) {
            $(ckbox ).prop( "checked", false );
        } else {
            $(ckbox ).prop( "checked", true );
        }
     
}
function setUnitId(courseCode,id,ElectiveCount,RequiredCount)
{    
    $('#unitcheckval').val(id);
   var ckbox = $('#span_'+$('#unitcheckval').val());
   var count = $('input[name="chk-val-'+courseCode+'[]"]:checked').length;
    if((ckbox.is(':checked')) && (count > RequiredCount))
    {
        $("#validate-info").modal('show');
    }
    else if((ckbox.is(':checked')))
    {
        $("#myModal").modal('show');
    }
    else{
        $("#myModal_uncheck").modal('show');
    }
}

function convertToEdit(courseCode)
{                
    
                  $("#btn-done-"+courseCode).removeClass('hide');
                  $("#btn-done-"+courseCode).addClass('show');
                  $("#btn-done-"+courseCode).show();
                  $('#edit_'+courseCode).removeClass('show');
                  $('#edit_'+courseCode).addClass('hide');
               // $('#course_toggle_'+courseCode).addClass('hide');
                  $("#course_toggle_"+courseCode).removeClass('show').addClass('hide');
                  $('#edit_'+courseCode).hide();
                
      $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').each(function(){
                        $(this).removeClass('edit-show');
                        $(this).addClass('hide');
             });
                 
                 $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').prev().each(function(){
                      $(this).addClass('edit-show');
                        $(this).removeClass('hide');
                 });
}
function convertToCheck(courseCode)
{
        $("#btn-done-"+courseCode).removeClass('show');
        $("#btn-done-"+courseCode).addClass('hide');
        $("#btn-done-"+courseCode).hide();
        $('#edit_'+courseCode).removeClass('hide');
        $('#edit_'+courseCode).addClass('show');                
        $('#edit_'+courseCode).show();
        $("#course_toggle_"+courseCode).removeClass('hide').addClass('show');
        $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').each(function(){
                        $(this).removeClass('hide');
                        $(this).addClass('edit-show');
        });                 
        $('#nested-collapseSTR-'+courseCode).find('div.user-redirect-arrow').prev().each(function(){
             $(this).addClass('hide');
               $(this).removeClass('edit-show');
        });
}
//Mobile Version Change Password
function checkCurrentOthersPassword(){
    mypassword = $('#current_password').val();
    $("#hdn_pwd_check").val("0");
    $("#profile_suc_msg2").hide();
    var startdiv = '<div class="gq-id-pwd-error-text alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    var mypassword = mypassword;
    $("#pwd_error").html('');
    $("#pwd_error").show();
    $(".chngpwddiv").addClass("hidden-xs");
    //$("#pwd_error").html(startdiv + 'Please wait till password gets validated' + enddiv);
    if(mypassword!="") {        
        $.ajax({
            type: "POST",
            url: "checkMyPassword",
            cache: false,
            data: {mypassword: mypassword},
            success: function(response) {               
                result = JSON.parse(response); 
                $('#change_pwd_error').show();              
                if (result.status == "fail") {
                    $("#hdn_pwd_check").val("0");
                    $("#pwd_error").html(startdiv + 'Current Password is not correct' + enddiv).delay(3000).fadeOut(100);
                    $("#current_password").val('');
                    $("#current_password").focus();                    
                    return false;
                }
                else if (result.status == "success") {
                    val = $("#current_password").val;
                    $("#password_oldpassword").val=val;
                    $("#idfiles").addClass("hidden-xs");
                    $("#user_profile_form_div").hide();
                    $(".currentpassword").addClass("hidden-xs");
                    $(".chngpwddiv").removeClass("hidden-xs");
                    $('#password_newpassword').val('');
                    $('#password_confirmnewpassword').val('');
                }
            }
        });
    }
    else
    {
        $("#pwd_error").html(startdiv + 'Please enter current password' + enddiv).delay(3000).fadeOut(100);
    }
}
$("#change_link").click(function(){
    $('#pwd_error').hide();
    $("#user_profile_form_div").hide();
    $(".title_bar").hide();
    $("#profile_suc_msg2").hide();
    $("#change_address_error").hide();
    $("#ajax-profile-error").hide();
    $("#user_profile_form").hide();
    $(".currentpassword").removeClass("hidden-xs");
    $("#fileListContainerPi").hide();
    $("#matrixfileDiv").hide();
    $("#current_password").val('');
});

$(".chngpwdvalOthers").click(function(){ 
 $('#mbl_pwd_error').html(''); 
 $("#profile_suc_msg2").hide();
 var curpwd = $("#password_hdnoldpassword").val(); 
 var displayConfirmPwd = $("#password_confirmnewpassword").parent().css( "display" );        
 var newpwd = $("#password_newpassword").val();
 var newconfirmpwd = $("#password_confirmnewpassword").val();
 if (newpwd == "") {
 $('#mbl_pwd_error').html("Please enter New Password");
 passwordShowMsg("Please enter New Password", "password_newpassword");
 return false;
 }
 if (newpwd != "") {
     if (newpwd.length < 8) {
         $('#mbl_pwd_error').html("New Password must be minimum of 8 characters");
         passwordShowMsg("New Password must be minimum of 8 characters", "password_newpassword");
         return false;
     }
     if (!(/[0-9]/.test(newpwd) && /[a-zA-Z]/.test(newpwd))) {    // Password should contain atleast one letter and one number
          $('#mbl_pwd_error').html("Password should contain atleast one letter and one digit");
            passwordShowMsg("Password should contain atleast one letter and one digit", "password_newpassword");
            return false;
        }
 }
 if (newconfirmpwd == "") {
     $('#mbl_pwd_error').html("Please enter Confirm Password");
     passwordShowMsg("Please enter Confirm Password", "password_confirmnewpassword");
     return false;
 }
 if (newconfirmpwd != "" && displayConfirmPwd != 'none') {

     if (newconfirmpwd.length < 8) {
         $('#mbl_pwd_error').html("New Confirm Password must be minimum of 8 characters");
         passwordShowMsg("New Confirm Password must be minimum of 8 characters", "password_confirmnewpassword");
         return false;
     }
 }
 if (newpwd != "" && newconfirmpwd != "") {
     if (curpwd == newpwd) {
         $('#mbl_pwd_error').html("Current Password and New Password must be different");
         passwordShowMsg("Current Password and New Password must be different", "password_newpassword");
         $("#password_confirmnewpassword").val('');
         return false;
     }
     if (newpwd != newconfirmpwd)
     {
          $('#mbl_pwd_error').html("New Password and Confirm Password does not match");
         passwordShowMsg("New Password and Confirm Password does not match", "password_confirmnewpassword");
         return false;
     }       
     $("#profile_suc_msg2").hide();
  $.ajax({
     type: "POST",
     url: base_url+"updatepasswordAjax",
     cache: false,
     data: {password_newpassword:newpwd},
     success: function(result) {
      $('#current_password').val('');
      $('#password_newpassword').val('');
      $('#password_confirmnewpassword').val('');
      $("#user_profile_form_div").hide();
    $(".title_bar").hide();
    $("#profile_suc_msg2").hide();
    $("#change_address_error").hide();
    $("#ajax-profile-error").hide();
    $("#user_profile_form").hide();
    $(".currentpassword").addClass("hidden-xs");    
     $(".chngpwddiv").addClass("hidden-xs");
     $(".pwdsucc").removeClass("hidden-xs");

     }
});

 }     

});
$('.clear_pswd_div_others').click(function()
{ 
            $("#user_profile_form_div").show();
            $("#profile2").modal('show');
            $(".title_bar").show();           
            $("#change_address_error").show();
            $("#ajax-profile-error").show();
            $("#user_profile_form").show();
            $(".currentpassword").addClass("hidden-xs");
            $(".chngpwddiv").addClass("hidden-xs");
            $(".pwdsucc").addClass("hidden-xs");
            $(".header-border").removeClass("hidden-xs");
            $(".mobi-profile").removeClass("hidden-xs");
            $("#profile_suc_msg2").hide();
			$("#fileListContainerPi").hide();
			$("#matrixfileDiv").show();
});
function addNewUserbyRole(roletype)
{
    $.ajax({
        type: "GET",
        url: base_url + "addUser/"+roletype,
        cache: false,
        data: {roletype:roletype},
        success: function(result) { 
            $(".add-user-byrole").html(result);
            $('#roleprofile2').modal('show');
        }
    });
}
function editUserbyRole(roletype)
{
    $.ajax({
        type: "GET",
        url: base_url + "editUser/"+roletype,
        cache: false,
        data: {roletype:roletype},
        success: function(result) { 
            $(".add-user-byrole").html(result);
            $('#roleprofile2').modal('show');
        }
    });
}

/*Log List*/
$("body").on("click", ".gq-ajax-log-pagination", function() {   
    pagenum = $(this).attr("page"); 
    loadDataIcon('currentList');
    loadUserLogReports('currentList',pagenum);
});
$("#searchUserLogFilter").click(function() { 
    pagenum = 1;    
    loadDataIcon('currentList');
    loadUserLogReports('currentList',pagenum);
});
function loadUserLogReports(divContent,pagenum)
{
    filterByDate = $('#logdate').val();
    searchName = $('#searchName').val();
    filterByRole = $('#userType').val();
    filterByAction = $('#filterByAction').val();
    //console.log(filterByAction+"--"+searchName+"--"+filterByRole);
    $.ajax({
        type: "POST",
        url: base_url + "searchLogList",
        cache: false,
        data: {filterByDate:filterByDate, pagenum:pagenum, searchName:searchName, filterByRole:filterByRole, filterByAction:filterByAction},
        success: function(result) {
            $("#current").show();
            $("#filter-by-all").hide();
            $('#' + divContent).html(result);
        }
    });
    
}

$(window).load(function() {
  setTimeout(function(){
   if($('.selected-doctype').length > 0){
        $('.selected-doctype').each(function(){
            var eleName="#doc-type-"+$(this).attr('id');
            $(eleName).parent().parent().addClass('disabled');
        }); 
    }
},300);
});

//Mangeuser Edit 
 $("#change-pwd-link").click(function(){
    $(".adduser_profile_form").hide();
    $(".changepassword").show();
});
$(".cancel-change-password").click(function(){
    $(".adduser_profile_form").show();
    $(".changepassword").hide();
});
function profileModal()
{
    $('#profile2').modal('hide'); 
    $('#profile_suc_msg2').hide();
}
function userExistMsg(errorMsg,msgId)
{
    var startdiv = '<div class="gq-well gq-id-file-error-text alert alert-danger"><h2>';
    var enddiv = '</h2></div>';
    $("#change_pwd_error").show();
    $("#change_pwd_error").html(startdiv + errorMsg + enddiv);
    if($("#"+msgId).val() != "")
        $("#"+msgId).val('');
    $("#"+msgId).focus();
	$('.body_section').scrollTop(0);
}
/* function to check email already exist */
function checkUserNameExist(username) {
    var count = '';
    $.ajax({
        type: "POST",
        url: base_url + "checkUserNameExist",
        async: false,
        data: {username: username},
        success: function(result) {           
           count = result;
        }
    });
    return count;
}

function validateNewMessage(toMessage,sublect,composeMsg)
{    
    if(toMessage == "")
    {
       
        userExistMsg("Please enter Firstname and Lastname", "compose_toUserName");
        return false;
    }
    else
    {        
        var count = checkUserNameExist(toMessage);    
        if (count == 0) {
             window.scrollBy(0,  200);
            userExistMsg("User does not exist. Please select a valid user!","compose_toUserName");            
            return false;
        }
    }
    if(sublect == "")
    {
        userExistMsg("Please enter subject","compose_subject");
        return false;
    }
    if(composeMsg == "")
    {
        userExistMsg("Please enter Message","compose_message");
        return false;
    }
  
}
function formSubmitAction(){    
    document.getElementById('compose_save').disabled=true;
    
}

/* function to check email already exist */
function checkUserNameExist(username) {
    var count = '';
    $.ajax({
        type: "POST",
        url: base_url + "checkUserNameExist",
        async: false,
        data: {username: username},
        success: function(result) {           
           count = result;
        }
    });
    return count;
}
/*Log list*/
/*Evidence Count in Menu*/
function onloadEvidenceCount()
{    
    $.ajax({
        url: base_url + "unreadEvidenceCount",
        cache: false,
        success: function(result) {         
            if (result >= 0) {    
                if(result==0)
                {
                    $('#evidenceCount').css("display","none");
                }
                $(".evidence-current").text(result);
				$("#evidenceCount").attr('class', '');	
//                    if(window.parent.opener) window.parent.opener.location.reload();
            } else {                
                $(".evidence-current").css("display","none");
            }
        }
    });
}
function assignfacvalidate(val,val2)
{
    if(val == 0)
        $('#update_popup_'+val2).modal('hide');
    else
    {
        $('#fac_tick_'+val2).removeClass('hide').addClass('check'); 
        $('#update_popup_'+val2).modal('hide');
    }
}
function assignassvalidate(val,val2)
{
    if(val == 0)
        $('#update_assessor_'+val2).modal('hide');
         
    else
    {
        $('#ass_tick_'+val2).removeClass('hide').addClass('check');
        $('#update_assessor_'+val2).modal('hide');
    }
}
function assignrtovalidate(val,val2)
{   
    if(val == 0)
        $('#update_rto_'+val2).modal('hide');        
    else{        
        $('#rto_tick_'+val2).removeClass('hide').addClass('check');
        $('#update_rto_'+val2).modal('hide'); 
        
    }
}
function fousOnNote(reqId){
    $("#ui-datepicker-div").hide();
}
function fousOnDate(){
    $("#ui-datepicker-div").show();
}
$('body').on('mouseup','#evidencefiles_previous', function() {
    moveToTop()
});
$('body').on('mouseup','#evidencefiles_next', function() {
    moveToTop()
});
$('body').on('touchend','#evidencefiles_previous', function() {
    mobileMoveToTop();
});
$('body').on('touchend','#evidencefiles_next', function() {
    mobileMoveToTop();
});
function moveToTop(){
    $('html, body').animate({scrollTop : 0}, "5000");
}
function mobileMoveToTop(){
    $('.body_section').animate({scrollTop : 0}, "5000");
}

function setValtoMessage(val){
  
    sessionStorage.msgUser = val;

 window.location.href = base_url+'messages/compose'; 
}

function addZeroDecimal(reqval){
    if(reqval<10){
     return '0'+reqval;
    }
    return reqval;
}
function getDisplayDate(reDateStr){

    var dateStrArr=reDateStr.split(' ');
    var acDate=dateStrArr[0].split('/');
    var acTime=dateStrArr[1].split(':');
    var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

    var currentDate = new Date(acDate[2],Number(acDate[1])-1,acDate[0],acTime[0],acTime[1],00,00);
    var displayDate=days[currentDate.getDay()]+' '+addZeroDecimal(currentDate.getDate())+'/'+addZeroDecimal(currentDate.getMonth())+' '+addZeroDecimal(currentDate.getHours())+':'+addZeroDecimal(currentDate.getMinutes())+dateStrArr[2].toUpperCase()+" ";
    return displayDate;
}

var ccToggle=true;
function courseToggle(req){
    ccToggle=!ccToggle;
    if(ccToggle){
        $(req).find('i').text('expand_less');
    }else{
        $(req).find('i').text('expand_more');
        setTimeout(function(){ 
          var cePos=  $(req).offset();
          var movable=cePos.top-30;
          $("html, body").animate({ scrollTop: movable }, "slow");},100);
    }
}