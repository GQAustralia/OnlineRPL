
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
    var userRole = $('#applicantEStatus').attr('userRole');
    var courseName = $('#hid-course-name').val();
    var unitName = $('#hid-unit-name').val();
    $('.loading-icon').show();
    $.ajax({
        type: "POST",
        url: fullPath + "setUserUnitEvidencesStatus",
        data: { unit: unit, userId: userId, userRole: userRole, status: '1', courseName: courseName, unitName: unitName },
        success:function(result) {
            if (result == '1') {
                $('#gq-msg-success').hide();
                $('.gq-id-files-upload-success-text').show();
                $('.gq-id-files-upload-success-text').html('<h2><img src="'+ fullPath +'public/images/tick.png">Evidence Approved successfully!</h2>');
            } else {
                $('.gq-id-files-upload-success-text').show();
                $('.gq-id-files-upload-success-text').html('<h2><img src="'+ fullPath +'public/images/tick.png">Evidence Disapproved successfully!</h2>');
            }
        }
    });
    $('.loading-icon').hide();
});

$("#disapprove").click(function () {
    var userRole = $('#applicantEStatus').attr('userRole');
    var courseName = $('#hid-course-name').val();
    var unitName = $('#hid-unit-name').val();
    $('.loading-icon').show();
    $.ajax({
        type: "POST",
        url: fullPath + "setUserUnitEvidencesStatus",
        data: { unit: unit, userId: userId, userRole: userRole, status: '0', courseName: courseName, unitName: unitName },
        success:function(result) {
            if (result == '1') {
                $('#gq-msg-success').hide();
                $('.gq-id-files-upload-success-text').show();
                $('.gq-id-files-upload-success-text').html('<h2><img src="'+ fullPath +'public/images/tick.png">Evidence Approved successfully!</h2>');
            } else {
                $('.gq-id-files-upload-success-text').show();
                $('.gq-id-files-upload-success-text').html('<h2><img src="'+ fullPath +'public/images/tick.png">Evidence Disapproved successfully!</h2>');
            }
        }
    });
    $('.loading-icon').hide();
});