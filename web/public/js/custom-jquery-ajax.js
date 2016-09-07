
/*$(".viewModalClass").click(function () {
    fileid = $(this).attr('fileid');
    filetype = $(this).attr('filetype');
});*/

$("#cclose-cancel").click(function () { 
    $('#myModalDel').removeClass('fade');
    //$('#myModalDel').modal('hide');
    //$( "#cclose" ).trigger( "click" );
});
//$(".deleteEvidence").click(function () {
$(".viewModalClass").click(function () {
    var c = confirm("Do you want to delete selected file ?");
    if (c == true) {
        fileid = $(this).attr('fileid');
        filetype = $(this).attr('filetype');
        var fid = fileid;
        var ftype = filetype;
        $.ajax({
            type: "POST",
            url: "../deleteEvidenceFile",
            data: { fid: fid, ftype: ftype },
            success:function(result) {
                $('#evd_'+fid).hide();
                $("#evidence_msg").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="../../web/public/images/tick.png">Evidence File deleted successfully!</h2></div>');
            }
        });
    }
});

$("body").on('click', '#approveyes', function() {
    $(this).prop('disabled', true);
    var newunit = $('#unit-code').val();
    var userId = $('#userid').val();
    var userRole = $('#applicantEStatus').attr('userRole');
	var courseName = $('#course-name').val();
    var unitName = $('#unit-name').val();
    var courseCode = $('#course-code').val();
    $.ajax({
        type: "POST",
        url: base_url + "setUserUnitEvidencesStatus",
        data: { unit: newunit, userId: userId, userRole: userRole, status: '1', courseName: courseName, unitName: unitName, courseCode: courseCode },
        success:function(result) {
            var newresult = result.split("&&");
            if (newresult[0] == '1') {
			    $('#satisfactory-myModal').modal('hide');
                location.reload();
            }
            if (newresult[1] == '1') {
            }
            else {
            }
        }
    });
    $('.loading-icon').hide();
});
$(".material-icons.close").click(function(){
     $('#message_popup').modal('hide');
})
$("#approveno").click(function () {
     $('#satisfactory').modal('hide');
});
$("#disapproveno").click(function () {
     $('#not-satisfactory').modal('hide');
});
$(".modal-body span.close").click(function(){
    $('#currProfile').modal('hide');
    $('#facProfile').modal('hide');
    $('#assProfile').modal('hide');
});

$("body").on('click', '#disapproveyes', function() {
    $(this).prop('disabled', true);
    var newunit = $('#unit-code').val();
    var userId = $('#userid').val();
    var toUserId = $('#fromuser-id').val();
    var userRole = $('#applicantEStatus').attr('userRole');
	var courseName = $('#course-name').val();
    var unitName = $('#unit-name').val();
    var unitId = $('#unit-id').val();
    var courseCode = $('#course-code').val();
    var msgBody = $('#msg-body').val();
    if (msgBody === '') {
        $('#msg-body').focus();
        $('#msg-body').css("border","1px solid red");
        return false;
    }
//    var subject = "Evidenced are Not sufficient for the unit "+ unitName +"";    
//	$.ajax({
//        type: "POST",
//        url: base_url + "sendMsgtoApplicant",
//        data: { unitId: unitId, userId: userId, toUser: toUserId, subject: subject, message: msgBody},
//        success:function(result) {
//        }
//    });

    $.ajax({
        type: "POST",
        url: base_url + "setUserUnitEvidencesStatus",
        data: { unit: newunit, userId: userId, userRole: userRole, status: '2', courseName: courseName, unitName: unitName, courseCode: courseCode, msgBody: msgBody },
        success:function(result) {
            var newresult = result.split("&&");
            if (newresult[0] == '2') {
                $('#non-satisfactory').modal('hide');
                location.reload();
            }
        }
    });
});
$("body #courseUnitNote").click(function(){
    var noteMsg = $('#note-msg').val();
    var courseId = $('#courseId').val();
    var noteType = $('#noteType').val();
    if (noteMsg === '') {
        $('#note-msg').focus();
        $('#note-msg').css("border","1px solid red");
        return false;
    }
    if (noteMsg != '') {
        $.ajax({
            type: "POST",
            url: base_url + "addNotes",
            data: { noteMsg: noteMsg, courseId: courseId, noteType: noteType},
            success:function(result) {
                $("body #status-message").css("display", "block");
                $("body .status-message").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png"> Note Added successfully</h2></div>');
            }
        });
    }
})

$("body .setToDoList").click(function() {
    userCourseId = $(this).attr("userCourseId");
    listId = $(this).attr("listId");
    var remindDate = $('#remindDate').val();
    var todoMsg = $('#todolist-msg').val();
    if (todoMsg === '') {
        $('#todolist-msg').focus();
        $('#todolist-msg').css("border","1px solid red");
        return false;
    }
    if (remindDate === '') {
        $('#remindDate').focus();
        $('#remindDate').css("border","1px solid red");
        return false;
    }
    if (remindDate != '') {
        $.ajax({
            type: "POST",
            url: base_url + "addReminder",
            cache: false,
            data: {message: todoMsg, userCourseId: userCourseId, remindDate: remindDate, listId: listId},
            success: function(result) {
                $("body #status-message").css("display", "block");
                $("body .status-message").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png"> Reminder Added successfully</h2></div>');
            }
        });
    }
});
$("body .msgForCourse").click(function(){
    var to = $('#advanced-demo').val();
    var unitId = 0;
    var subject = $('#msgSubject').val();
    var msgBody = $('#msgBody').val();
    var userId =  $('#UserId').val();
    if (to === '') {
        $('#advanced-demo').focus();
        $('#advanced-demo').css("border","1px solid red");
        return false;
    }
    if (msgBody === '') {
        $('#msgBody').focus();
        $('#msgBody').css("border","1px solid red");
        return false;
    }
    if (to != '' && msgBody != '') {
        $.ajax({
            type: "POST",
            url: base_url + "sendMsgtoApplicant",
            data: { unitId: unitId, userId: userId, subject: subject, message: msgBody},
            success:function(result) {
                $('#message_popup').modal('hide');
                $("body #status-message").css("display", "block");
                $("body .status-message").html('<div class="gq-id-files-upload-success-text" style="display: block;"><h2><img src="' + base_url + 'public/images/tick.png"> Sent message successfully</h2></div>');
                
            }
        });
    }
})
