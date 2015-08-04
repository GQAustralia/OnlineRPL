
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
    var c = confirm("Do yo want to delete selected file ?");
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

$("#approve").click(function () {
    var newunit = unit;
    var userRole = $('#applicantEStatus').attr('userRole');
    var courseName = $('#hid-course-name').val();
    var unitName = $('#hid-unit-name').val();
    var courseCode = $('#hid-course-code').val();    
    $(this).parent().next('.loading-icon').show();
    $.ajax({
        type: "POST",
        url: base_url + "setUserUnitEvidencesStatus",
        data: { unit: newunit, userId: userId, userRole: userRole, status: '1', courseName: courseName, unitName: unitName, courseCode: courseCode },
        success:function(result) {
            var newresult = result.split("&&");
            if (newresult[0] == '1') {
                $('#applicantEStatus').hide();
                $('.gq-id-files-upload-success-text').show().html('<h2><img src="'+ base_url +'public/images/tick.png">Evidence provided is acceptable!</h2>').delay(3000).fadeOut(100);
                $('#'+ newunit +'_approveStatus').html('<span class="pull-right gq-acc-book-icon"><img src="'+ base_url +'public/images/bookopen.png"></span>');
            }
            if (newresult[1] == '1') {
                $(".approve-for-certification-btn").hide();
                $(".approve-for-certification-btnajax").show();
                $("#disabled-btn").hide();
            }
            else {
                $(".approve-for-certification-btn").show();
                $(".approve-for-certification-btnajax").hide();
                $("#disabled-btn").show();
            }
        }
    });
    $('.loading-icon').hide();
});

$("#disapprove").click(function () {
    var newunit = unit;
    var userRole = $('#applicantEStatus').attr('userRole');
    var courseName = $('#hid-course-name').val();
    var unitName = $('#hid-unit-name').val();
    var courseCode = $('#hid-course-code').val();
    $('.loading-icon').show();
    $.ajax({
        type: "POST",
        url: base_url + "setUserUnitEvidencesStatus",
        data: { unit: newunit, userId: userId, userRole: userRole, status: '2', courseName: courseName, unitName: unitName, courseCode: courseCode },
        success:function(result) {
            var newresult = result.split("&&");
            if (newresult[0] == '2') {
                $('#applicantEStatus').hide();
                $('.gq-id-files-upload-success-text').show().html('<h2><img src="'+ base_url +'public/images/tick.png">Marked as unacceptable!</h2>').delay(3000).fadeOut(100);
                $('#'+ newunit +'_approveStatus').html('<span class="pull-right gq-acc-book-icon"><img src="'+ base_url +'public/images/bookclosed.png"></span>');
            }
        }
    });
    $('.loading-icon').hide();
});