var qual_id;
var fileid;
var filetype;
var unitId;
var courseCode;
var userId;
var unit;
var fullPath = '/';
var reminderid;
var reminderflag;
var otherfiles;

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
                    $("#eqclose").trigger("click");
                    $("#editEvidenceModelinput").val(title);
                    $("#ev-" + id).attr("data-evtitle", title);
                    $("#evd-title-" + id).html(title);
                    $(".edittitle_loader").hide();
                }
            }
        });
    });
});

$( "#view_terms" ).click(function() {
    $.ajax({url:"updateCondition",success:function(result){
    }}); 
});

$(".modalClass").click(function () {
    qual_id = this.id;
});
$("#qclose").click(function () {
    if (qual_id != '' && typeof  qual_id === 'undefined') {
       $(location).attr('href','qualificationDetails/'+qual_id);
    }
});

$(".checkmark-icon").click(function () {
    unitId = $(this).attr("unit_id");
    courseCode = $(this).attr("course_code");
    userId = $(this).attr("user_id");
});

$(".changeUnitStatus").click(function () {
   //var c = confirm("Do yo want to change the status of elective unit ?");
   //if (c == true) {
        $.ajax({
            type: "POST",
            url: "../updateUnitElective",
            data: { unitId: unitId, courseCode: courseCode, userId: userId },
            success:function(result) {
                var label = $( "#label_"+unitId ).attr("temp");
                if (result == '0') {
                    $( "#label_"+unitId ).attr("for","");
                    $( "#btnadd_"+unitId ).attr('disabled','disabled');
                    $( "#btneye_"+unitId ).attr('disabled','disabled');
                    $( "#div_"+unitId ).addClass( "gq-acc-row-checked" );
                    $( "#span_"+unitId ).removeClass( "radioUnChecked" );
                    $( "#sp_"+unitId ).html('');
                } else {
                    $( "#label_"+unitId ).attr("for",label);
                    $( "#btnadd_"+unitId ).removeAttr('disabled');
                    $( "#btneye_"+unitId ).removeAttr('disabled');
                    $( "#div_"+unitId ).removeClass( "gq-acc-row-checked" );
                    $( "#span_"+unitId ).addClass( "radioUnChecked" );
                }
            }
        });
        $( "#qclose" ).trigger( "click" );
   //}
});

$(".fromBottom").click(function () {
    unit = $(this).attr("unitid");
    courseCode = $(this).attr("course_code");
    $('#file_hid_unit').val(unit);
    $('#file_hid_course').val(courseCode);
    $('.gq-dashboard-tabs').show();
    $('#gq-dashboard-tabs-success').hide();
    $('#file_save').show();
    $('#frmAddEvidence')[0].reset();
    $('#frmSelectEvidence')[0].reset();
});

$("#frmSelectEvidence").submit(function () {
     $('#select_hid_unit').val(unit);
});

$(".deleteEvidence").click(function () {
   //var c = confirm("Do yo want to delete selected file ?");
   //if (c == true) {
        var fid = fileid;
        var ftype = filetype;
        $.ajax({
            type: "POST",
            url: "deleteEvidenceFile",
            data: { fid: fid, ftype: ftype },
            success:function(result) {
                $('#evd_'+fid).hide();
                //alert("Selected Evidence File deleted!");
                $( "#qclose" ).trigger( "click" );
                $("#evidence_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="../web/public/images/tick.png">Evidence File deleted successfully!</h2></div>');
            }
        });
   //}
});

$(".deleteIdFiles").click(function () {
    var fid = fileid;
    var ftype = filetype;
    var url = (otherfiles)?"deleteOtherFiles":"deleteIdFiles";
    $.ajax({
        type: "POST",
        url: url,
        data: { fid: fid, ftype: ftype },
        success:function(result) {
            $('#idfiles_'+fid).hide();
            $( "#fclose" ).trigger( "click" );
            $("#idfiles_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="../web/public/images/tick.png">File deleted successfully!</h2></div>').delay(5000).fadeOut(100); 
        }
    });
});


$("#frmAddEvidence").ajaxForm({
    beforeSubmit: function() {
        $('#file_save').hide();
    },
    success: function(responseText, statusText, xhr, $form) {
        $('.gq-dashboard-tabs').hide();
        $('#gq-dashboard-tabs-success').show();
        if (responseText == '0') {
            $('#gq-dashboard-tabs-success').html('<h2><img src="../../web/public/images/tick.png">Evidence upload successfully!</h2>');
        } else {
            $('#gq-dashboard-tabs-success').html('<h2><img src="../../web/public/images/tick.png">File size below 10MB are only  upload successfully!</h2>');
        }
    },
    resetForm: true
});

$("#frmSelectEvidence").ajaxForm({
    beforeSubmit: function() {
        $('#file_save').hide();
    },
    success: function() {
        $('.gq-dashboard-tabs').hide();
        $('#gq-dashboard-tabs-success').show();
        $('#gq-dashboard-tabs-success').html('<h2><img src="../../web/public/images/tick.png">Existing Evidence upload successfully!</h2>');
    },
    resetForm: true
});


$("#download_profile").click(function () {
    userId = $(this).attr("unitid");
    courseCode = $(this).attr("course_code");
    window.open("/downloadFiles/"+courseCode+"/"+userId);
    window.open("/zipFiles/"+courseCode+"/"+userId);
});

$(".todomodalClass").click(function () {
    reminderid = this.id;
    reminderflag = $(this).attr("data-flag");
});
$("#todo-cancel").click(function () {
    $( "#todoclose" ).trigger( "click" );
});

$(".updateTodo").click(function() {
    $(".todo_loader").show();
    var rmid = reminderid;
    var flag = reminderflag;
    if (flag == "0")
        flag = "1";
    else
        flag = "0";
    $.ajax({
        type: "POST",
        url: "updateTodo",
        data: {rmid: rmid, flag: flag},
        success: function(result) {
            if (result == "success") {
                $("#title_" + rmid).html('<span class="todo_day">Today</span>');
                $("#"+rmid).remove();
                $("#completed-tab").append("<div>" + $("#div_" + rmid).parent().parent().html() + "</div>");
                $("#div_" + rmid).parent().parent().remove();
                $(".todo_loader").hide();
                $("#todoclose").trigger("click");
            }
        }
    });
});

function validateExisting()
{
    var efile = $(".check_evidence:checkbox:checked").length;
    if(efile <= 0 || efile == '' || typeof  efile === 'undefined') {
        alert('Please select atleast one Existing Evidence!');
        return false;
    }
}

$("#userprofile_userImage").change(function(){
    var fileName = $(this).val();
    var Extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();

    if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {
        $("#ajax-loading-icon").show();
        var file_data = $('#userprofile_userImage').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);                     
        $.ajax({
                type: "POST",
                url: "uploadProfilePic",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success:function(result) {
                    if(result!="error")
                    {
                        $("#profile_suc_msg2").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="../web/public/images/tick.png">Profile Image updated successfully!</h2></div>');
                        
                        $("#ajax-profile-error").hide();
                        $(".ajax-profile-pic").attr('src', '../web/public/uploads/'+result);
                        $("#ajax-gq-profile-page-img").css("background-image", "url('../web/public/uploads/"+result+"')");
                        $("#ajax-loading-icon").hide();
                    }
                    else
                    {
                        $("#ajax-profile-error").show();
                        $("#ajax-profile-error").html("<p>Error in uploading.</p>");
                    }
                }
            });       
    }
    else
    {
        $("#ajax-profile-error").show();
        $("#ajax-profile-error").html("<p>Please upload valid image.</p>");
        //alert("Please upload valid image");
        return false;
    }
    
  });
  
  
$(".unit-evidence-id").click(function () {
    unit = $(this).attr("unitid");
    userId = $(this).attr("userId");
    $.ajax({
        type: "POST",
        url: fullPath + "getUnitEvidences",
        data: { unit: unit, userId: userId },
        success:function(result) {
            $('#unit-evidence-tab').html(result);
        }
    });
});

$("#userfiles_browse").click(function(){
  $("#idfiletype_image").html("");
});

$("#userfiles_browse").change(function(){
  var fileName = $(this).val();
  $("#idfiletype_image").html('<div class="col-lg2 col-md-2 col-sm-3 col-xs-12"><div class="gq-id-files-upload-txt">'+fileName+'</div></div>');
});

$("#qclose-cancel").click(function () {
    $( "#qclose" ).trigger( "click" );
});

$("#fclose-cancel").click(function () {
    $( "#fclose" ).trigger( "click" );
});


$(".viewModalClass").live("click", function () {
    fileid = $(this).attr('fileid');
    filetype = $(this).attr('filetype');
    otherfiles = $(this).attr('otherfiles');
});

$(".openIcon").click(function () {
    var c = $(this).hasClass( "open" );
    if (c == false) {
        $(this).addClass( "open" );
    } else {
        $(this).removeClass( "open" );
    }
});

$(".filesUpload").ajaxForm({
    beforeSubmit: function() {
        var type = $(this).attr('id');
        alert($( "form" ).closest( "div" ).attr('id'));
        return false;
        alert(type);
        $('#'+type+'_load').show();
    },
    success: function(responseText, statusText, xhr, $form) {
        $('#'+type+'_load').show();
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
            $('.resume_files').append(html);
            $('#'+type+'_msg').css("display", "block").delay(5000).fadeOut(100);
        }
    },
    resetForm: true
});

function checkspace(text)
{
    var str=text.value;
    var first=str.substring(0,1);
    var second=str.substring(0,1);
    var val='false';
    if(first==' ')
    {
        val='true';
        if(val=='true')
        {
            if(second==' ')
            {
                val='true';
                text.value = "";
            }
        }
    }
}

function checkCurrentPassword(mypassword)
{
    $("#hdn_pwd_check").val("0");
    var startdiv = '<div class="gq-well well"><span class="login-warning-icon" aria-hidden="true"></span><div class="login-warning-text">';
    var enddiv = '</div></div>';
    $("#change_pwd_error").html('<div class="gq-well well"><div class="login-warning-text">Please wait..'+enddiv);
    var mypassword = mypassword;
    $.ajax({
            type: "POST",
            url: "checkMyPassword",
            cache: false,
            data: { mypassword: mypassword },
            success:function(result) {
               if(result=="fail") {
                  $("#hdn_pwd_check").val("0"); 
                  $("#change_pwd_error").html(startdiv+'Current Password is not correct'+enddiv); 
                  $("#password_oldpassword").val('');
               }
               else if(result=="success") {
                  $("#change_pwd_error").html('<div class="gq-well well"><div class="login-warning-text">Current Password is correct'+enddiv);
                  $("#hdn_pwd_check").val("1"); 
               }
            }
    });      
}

$(".setNotes").click(function () {
    id = $(this).attr("id");
    var c = $('#div_'+id).hasClass( "open" );
    if (c == false) {
        $('#div_'+id).addClass('open');
    } else {
        $('#div_'+id).removeClass('open');
    }
});

$(".setData").click(function () {
    userCourseId = $(this).attr("userCourseId");
    note = $('#notes_'+userCourseId).val();
    remindDate = $('#remindDate_'+userCourseId).val();
    $.ajax({
        type: "POST",
        url: "addReminder",
        cache: false,
        data: {message: note, userCourseId: userCourseId, remindDate: remindDate},
        success: function(result) {
            $('#div_'+userCourseId).removeClass('open');
            $("#err_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="../web/public/images/tick.png">Reminder added succesfully!</h2></div>');
        }
    });
});
var applicantStatus = '0';
$("#timeRemaining").change(function () {
    loadApplicantList('currentList');
});

$("#searchFilter").click(function () {
    loadApplicantList('currentList');
});

$("#applicantPending").click(function () {
    applicantStatus = '0';
    loadApplicantList('currentList');
});

$("#applicantCompleted").click(function () {
    applicantStatus = '1';
    loadApplicantList('completedList');
});

function loadApplicantList(divContent)
{
    searchName = $('#searchName').val();
    searchTime = $('#timeRemaining').val();
    $.ajax({
        type: "POST",
        url: "searchApplicantsList",
        cache: false,
        data: {searchName: searchName, searchTime: searchTime, status: applicantStatus},
        success: function(result) {
            $('#'+divContent).html(result);
        }
    });
}
function getCompletedtabData()
{
    var data = "this is ajax data";
    $("#completed-tab").html(data);
}