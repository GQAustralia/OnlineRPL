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

$("#view_terms").click(function() {
    $.ajax({url: "updateCondition", success: function(result) {
        }});
});

$(".modalClass").click(function() {
    qual_id = this.id;
});
$("#qclose").click(function() {
    if (qual_id != '' && typeof qual_id === 'undefined') {
        $(location).attr('href', 'qualificationDetails/' + qual_id);
    }
});

$(".checkmark-icon").click(function() {
    unitId = $(this).attr("unit_id");
    courseCode = $(this).attr("course_code");
    userId = $(this).attr("user_id");
});

$(".changeUnitStatus").click(function() {
    $(".qual_status_loader").show();
    $.ajax({
        type: "POST",
        url: base_url + "updateUnitElective",
        data: {unitId: unitId, courseCode: courseCode, userId: userId},
        success: function(result) {
            var label = $("#label_" + unitId).attr("temp");
            if (result == '0') {
                $("#label_" + unitId).attr("for", "");
                $( "#label_"+unitId ).attr('disabled','disabled');
                $("#btnadd_" + unitId).attr('disabled', 'disabled');
                $("#btneye_" + unitId).attr('disabled', 'disabled');
                $("#div_" + unitId).addClass("gq-acc-row-checked");
                $("#span_" + unitId).removeClass("radioUnChecked");
                $("#sp_" + unitId).html('');
            } else {
                $("#label_" + unitId).attr("for", label);
                $( "#label_"+unitId ).removeAttr('disabled','disabled');
                $("#btnadd_" + unitId).removeAttr('disabled');
                $("#btneye_" + unitId).removeAttr('disabled');
                $("#div_" + unitId).removeClass("gq-acc-row-checked");
                $("#span_" + unitId).addClass("radioUnChecked");
            }
            $(".qual_status_loader").hide();
            $("#qclose").trigger("click");
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
    $('#frmAddEvidence')[0].reset();
    $('#frmSelectEvidence')[0].reset();

    var c = $('#select-from-evidence-tab').hasClass("active");
    if (c == true) {
        $('#add-evidence-tab').addClass('active');
        $('#div_add_evidence').addClass('active');

        $('#select-from-evidence-tab').removeClass('active');
        $('#div_existing_evidence').removeClass('active');
    }
});

$("#frmSelectEvidence").submit(function() {
    $('#select_hid_unit').val(unit);
    $('#select_hid_course').val(courseCode);
});

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
            $("#evidence_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + '/public/images/tick.png">Evidence File deleted successfully!</h2></div>').delay(3000).fadeOut(100);
            $('.deleteevidence_loader').hide();
        }
    });
});

$(".deleteIdFiles").click(function() {
    var fid = fileid;
    var ftype = filetype;
    var url = (otherfiles) ? "deleteOtherFiles" : "deleteIdFiles";
    $.ajax({
        type: "POST",
        url: base_url + url,
        data: {fid: fid, ftype: ftype},
        success: function(result) {
            $("#idfiles_msg").show();
            $('#idfiles_' + fid).hide();
            $("#fclose").trigger("click");
            $("#idfiles_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png">File deleted successfully!</h2></div>').delay(5000).fadeOut(100);
        }
    });
});


$("#frmAddEvidence").ajaxForm({
    beforeSubmit: function() {
        $('#file_save').hide();
        $('.uploadevidence_loader').show();
    },
    success: function(responseText, statusText, xhr, $form) {
        $("#gq-dashboard-tabs-success").show();
        $('.gq-dashboard-tabs').hide();
        $('#gq-dashboard-tabs-success').show();
        $('.uploadevidence_loader').hide();
        if (responseText == '0') {
            $('#gq-dashboard-tabs-success').html('<h2><img src="' + base_url + 'public/images/tick.png">Evidence uploaded successfully!</h2>').delay(3000).fadeOut(100);
        } else {
            $('#gq-dashboard-tabs-success').html('<h2><img src="' + base_url + 'public/images/tick.png">File size below 10MB are only  upload successfully!</h2>').delay(3000).fadeOut(100);
        }
    },
    resetForm: true
});

$("#frmSelectEvidence").ajaxForm({
    beforeSubmit: function() {
        $('#file_save').hide();
        $('.uploadevidence_loader').show();
    },
    success: function() {
        $('.gq-dashboard-tabs').hide();
        $('.uploadevidence_loader').hide();
        $('#gq-dashboard-tabs-success').show();
        $('#gq-dashboard-tabs-success').html('<h2><img src="' + base_url + 'public/images/tick.png">Existing Evidence uploaded successfully!</h2>').delay(3000).fadeOut(100);
    },
    resetForm: true
});


$("#download_profile").click(function() {
    userId = $(this).attr("userid");
    courseCode = $(this).attr("course_code");
    window.open(base_url + "downloadFiles/" + courseCode + "/" + userId);
    window.open(base_url + "zipFiles/" + courseCode + "/" + userId);
});

$("#download_matrix").click(function() {
    window.open(base_url + "downloadMatrix");
});

$("#download_assessor_profile").click(function() {
    userId = $(this).attr("userid");
    window.open(base_url + "downloadAssessorProfile/" + userId);
});

$(".todomodalClass").click(function() {
    reminderid = this.id;
    reminderflag = $(this).attr("data-flag");
});
$("#todo-cancel").click(function() {
    $("#todoclose").trigger("click");
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
                $("#records-not-found").hide();
                $("#title_" + rmid).html('<span class="todo_day">Today</span>');
                $("#" + rmid).remove();
                $("#completed-tab").append("<div>" + $("#div_" + rmid).parent().parent().html() + "</div>");
                $("#div_" + rmid).parent().parent().remove();
                if(parseInt($(".gq-to-do-list-row-completed").length)==0)
                    $(".no-todo").show();
                $(".todo_loader").hide();
                $("#todoclose").trigger("click");
            }
        }
    });
});

function validateExisting()
{
    var efile = $(".check_evidence:checkbox:checked").length;
    if (efile <= 0 || efile == '' || typeof efile === 'undefined') {
        alert('Please select atleast one Existing Evidence!');
        return false;
    }
}

$("#userprofile_userImage").change(function() {
    var fileName = $(this).val();
    var Extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();

    if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {
        $("#ajax-loading-icon").show();
        var file_data = $('#userprofile_userImage').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            type: "POST",
            url: base_url + "uploadProfilePic",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(result) {
                if (result != "error")
                {
                    $("#profile_suc_msg2").show();
                    $("#profile_suc_msg2").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png">Profile Image updated successfully!</h2></div>').delay(3000).fadeOut(100);

                    $("#ajax-profile-error").hide();
                    $(".ajax-profile-pic").attr('src', base_url + 'public/uploads/' + result);
                    $("#ajax-gq-profile-page-img").css("background-image", "url('" + base_url + "public/uploads/" + result + "')");
                    $("#ajax-loading-icon").hide();
                }
                else
                {
                    $("#ajax-profile-error").show();
                    $("#ajax-profile-error").html("<p>Error in uploading.</p>").delay(3000).fadeOut(100);
                }
            }
        });
    }
    else
    {
        $("#ajax-profile-error").show();
        $("#ajax-profile-error").html("<p>Please upload valid image.</p>").delay(3000).fadeOut(100);
        //alert("Please upload valid image");
        return false;
    }

});


$(".unit-evidence-id").click(function() {
    unit = $(this).attr("unitid");
    userId = $(this).attr("userid");
    delStatus = $(this).attr("del-status");
    course_code = $(this).attr("course_code");
    course_name = $(this).attr("course_name");
    unittitle = $(this).attr("unittitle");
    $.ajax({
        type: "POST",
        url: base_url + "getUnitEvidences",
        data: {unit: unit, userId: userId, delStatus: delStatus, unittitle: unittitle, course_code: course_code, course_name: course_name},
        success: function(result) {
            $('#unit-evidence-tab').html(result);
        }
    });
});

$("#userfiles_browse").click(function() {
    $("#idfiletype_image").html("");
});

$(".show_path").change(function() {
    var fileName = $(this).val();
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


$("body").on("click", ".viewModalClass", function() {
    fileid = $(this).attr('fileid');
    filetype = $(this).attr('filetype');
    otherfiles = $(this).attr('otherfiles');
});

$(".openIcon").click(function() {
    var c = $(this).hasClass("open");
    if (c == false) {
        $(this).addClass("open");
    } else {
        $(this).removeClass("open");
    }
});

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
            var html = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" id="idfiles_' + result.id + '"><div class="gq-dashboard-courses-detail"><span class="gq-dashboard-points-icon">\n\
                            <a class="modalClass viewModalClass" data-toggle="modal" data-target="#myModal" fileid="' + result.id + '" filetype="' + result.type + '">\n\
                                <div class="gq-del-evidence"></div></a>\n\
                            <div class="tooltip-home top">\n\
                                <div class="tooltip-arrow"></div>\n\
                                <span class="">Delete ID File</span>\n\
                            </div>\n\
                        </span>\n\
                        <a href = "' + amazon_link + result.path + '" class="fancybox fancybox.iframe"><div class="gq-id-files-content-icon-wrap gq-id-files-content-doc-icon"></div></a><div class="gq-id-files-content-row-wrap"><div class="gq-id-files-content-row"><label>Title</label><span>' + ftype + '</span></div><div class="gq-id-files-content-row"><label>Added on</label><span>' + result.date + '</span></div></div></div></div>';
            if ($('#idfiles_no_files').html() === 'No Id files found') {
                $('.Id_files').html(html);
            } else {
                $('.Id_files').append(html);
            }
            $("#idfiles_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png">File added successfully!</h2></div>').delay(5000).fadeOut(100);
        }
    },
    resetForm: true
});

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
            $('#resume_msg').css("display", "block").delay(5000).fadeOut(100);
        }
    },
    resetForm: true
});

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
            $('#resume_msg').css("display", "block").delay(5000).fadeOut(100);
        }
    },
    resetForm: true
});

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
            if ($('#reference_no_files').html() === 'No reference letters found') {
                $('.reference_files').html(html);
            } else {
                $('.reference_files').append(html);
            }
            $('#resume_msg').css("display", "block").delay(5000).fadeOut(100);
        }
    },
    resetForm: true
});

$("#matrixUpload").ajaxForm({
    beforeSubmit: function() {
        $('#matrix_load').show();
    },
    success: function(responseText, statusText, xhr, $form) {
        $('#resume_msg').css("display", "block");
        $('#matrix_load').prev().html('');
        $('#matrix_load').hide();
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
            if ($('#matrix_no_files').html() === 'No trainer matrix found') {
                $('.matrix_files').html(html);
            } else {
                $('.matrix_files').append(html);
            }
            $('#resume_msg').css("display", "block").delay(5000).fadeOut(100);
        }
    },
    resetForm: true
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
    var startdiv = '<div class="gq-well well"><span class="login-warning-icon" aria-hidden="true"></span><div class="login-warning-text">';
    var enddiv = '</div></div>';
    var mypassword = mypassword;
    if(mypassword!="") {
        $("#change_pwd_error").show();
        $("#change_pwd_error").html('<div class="gq-well well"><div class="login-warning-text">Please wait..' + enddiv);
        $.ajax({
            type: "POST",
            url: "checkMyPassword",
            cache: false,
            data: {mypassword: mypassword},
            success: function(result) {
                $('#change_pwd_error').show();
                if (result == "fail") {
                    $("#hdn_pwd_check").val("0");
                    $("#change_pwd_error").html(startdiv + 'Current Password is not correct' + enddiv).delay(3000).fadeOut(100);;
                    $("#password_oldpassword").val('');
                    $("#password_oldpassword").focus();
                }
                else if (result == "success") {
                    $("#change_pwd_error").html('<div class="gq-well well"><div class="login-warning-text">Current Password is correct' + enddiv).delay(3000).fadeOut(100);;
                    $("#hdn_pwd_check").val("1");
                }
            }
        });
    }
}

$(".setNotes").click(function() {
    id = $(this).attr("id");
    var c = $('#div_' + id).hasClass("open");
    if (c == false) {
        if($(".gq-assessor-list-dropdown-wrap").hasClass("open"))
            $(".gq-assessor-list-dropdown-wrap").removeClass('open');
        $(this).parent().addClass('open');
        //$('#div_' + id).addClass('open');
    } else {
        $('#notes_' + id).val('').attr("placeholder", "Notes");
        $('#remindDate_' + id).val('').attr("placeholder", "Due Date");
        $(this).parent().removeClass('open');
        //$('#div_' + id).removeClass('open');
    }
});

$(".setData").click(function() {
    userCourseId = $(this).attr("userCourseId");
    note = $('#notes_' + userCourseId).val();
    remindDate = $('#remindDate_' + userCourseId).val();
    $("#setdata_load_"+userCourseId).show();
    if (remindDate != '') {
        $.ajax({
            type: "POST",
            url: "addReminder",
            cache: false,
            data: {message: note, userCourseId: userCourseId, remindDate: remindDate},
            success: function(result) {
                $("#setdata_load_"+userCourseId).hide();
                $('#err_msg').show();
                $('#notes_' + userCourseId).val('').attr("placeholder", "Notes");
                $('#remindDate_' + userCourseId).val('').attr("placeholder", "Due Date");
                $('#div_' + userCourseId).removeClass('open');
                $("#err_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png">Reminder added succesfully!</h2></div>').delay(3000).fadeOut(100);
            }
        });
    }
});

function onloadCount()
{
    $.ajax({
        url: base_url + "unread",
        success: function(result) {
            // alert(result);
            if (result > 0) {
                $("#unread-count").html('<span class="gq-ms-counter">' + result + '<span>');
            } else {
                $("#unread-count").html("");
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
                        } else {
                            $(".inbox-cnt").html("");
                            $("#unread-count").html("");
                        }
                        $("#chk-main-all").prop('checked', false);
                        $("#chk-main-all").prev().removeClass("checked");
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
                        } else {
                            $(".inbox-cnt").html("");
                            $("#unread-count").html("");
                        }
                        $("#chk-main-all").prop('checked', false);
                        $("#chk-main-all").prev().removeClass("checked");
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
    location.reload();
});

var applicantStatus = '0';
$("#timeRemaining").change(function() {
    $("#filter-by-week").show();
    loadApplicantList('currentList');
});

$("#searchFilter").click(function() {
    $("#filter-by-name").show();
    loadApplicantList('currentList');
});

$("#applicantPending").click(function() {
    $("#app-pending-approve").show();
    applicantStatus = '0';
    loadApplicantList('currentList');
});

$("#applicantCompleted").click(function() {
    $("#app-pending-approve").show();
    applicantStatus = '1';
    loadApplicantList('completedList');
});

function loadApplicantList(divContent)
{
    searchName = $('#searchName').val();
    searchTime = $('#timeRemaining').val();
    $.ajax({
        type: "POST",
        url: base_url + "searchApplicantsList",
        cache: false,
        data: {searchName: searchName, searchTime: searchTime, status: applicantStatus},
        success: function(result) {          
            $("#filter-by-name").hide();
            $("#filter-by-week").hide();
            $("#app-pending-approve").hide();
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
        //checkboxesSpans = document.getElementsByName('custom-chk-name');

        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = true;
        }
        $(".custom-checkbox").addClass("checked");
    }
    else
    {
        checkboxes = document.getElementsByName('chk_inbox');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = false;
        }
        $(".custom-checkbox").removeClass("checked");
    }
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
    $("#main-chk-id").removeClass("checked");
    document.getElementById("chk-main-all").checked = false;
    if ($("#chk-" + chkid).prev().hasClass("checked"))
        $("#chk-" + chkid).prev().removeClass("checked");
    else
        $("#chk-" + chkid).prev().addClass("checked");
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
function showMyTabs()
{
    $('#personel-gq-tab').tab('show');
    $('#personal').addClass('active');
    $('#address').removeClass('active');
}
function validateAddress()
{
    var useremail = $("#userprofile_email").val();
    regexp = /^[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/;

    var startMsg = '<div class="gq-well well"><span aria-hidden="true" class="login-warning-icon"></span><div class="login-warning-text">';
    var endMsg = '</div></div>';
    if ($("#userprofile_firstname").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter First Name" + endMsg);
        showMyTabs();
        $("#userprofile_firstname").focus();
        return false;
    }
    if ($("#userprofile_lastname").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter Last Name" + endMsg);
        showMyTabs();
        $("#userprofile_lastname").focus();
        return false;
    }
    if ($("#userprofile_email").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter Email" + endMsg);
        showMyTabs();
        $("#userprofile_email").focus();
        return false;
    }
    if ($("#userprofile_email").val() != "")
    {
        if (useremail.search(regexp) == -1) {
            $("#change_pwd_error").html(startMsg + "Please enter valid Email" + endMsg);
            showMyTabs();
            $("#userprofile_email").focus();
            return false;
        }
    }
    if ($("#userprofile_phone").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter Phone Number" + endMsg);
        showMyTabs();
        $("#userprofile_phone").focus();
        return false;
    }
    if ($("#userprofile_dateOfBirth").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter Date Of Birth" + endMsg);
        showMyTabs();
        $("#userprofile_dateOfBirth").focus();
        return false;
    }
    if ($("#userprofile_universalStudentIdentifier").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter USI" + endMsg);
        showMyTabs();
        $("#userprofile_universalStudentIdentifier").focus();
        return false;
    }
    if ($("#userprofile_address_address").val() == "")
    {
        $("#change_pwd_error").html(startMsg + "Please enter Address" + endMsg);
        $('#address-gq-tab').tab('show');
        $('#personal').removeClass('active');
        $('#address').addClass('active');
        $("#userprofile_address_address").focus();
        return false;
    }
}

$("#approve-for-certification").click(function() {
    var courseCode = $(this).attr("courseCode");
    var applicantId = $(this).attr("applicantId");
    $.ajax({
        type: "POST",
        url: base_url + "approveCertification",
        async: false,
        data: {courseCode: courseCode, applicantId: applicantId},
        success: function(result) {
            $('#approve_section').show();
            $("#approve_section").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="../../web/public/images/tick.png">This Qualification is Approved successfully!</h2></div>').delay(3000).fadeOut(100);
        }
    });
});
$(".gq-msg-title").children("a").click(function() {
    $(this).parent().parent().parent().addClass('gq-msg-visited');
});

function checkApproveButton()
{
    $(".gq-approve-error").show().delay(3000).fadeOut(100);
}