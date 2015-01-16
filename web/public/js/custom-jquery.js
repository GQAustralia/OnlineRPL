var t;
$(function(){
  var $ppc = $('.progress-pie-chart'),
    percent = parseInt($ppc.data('percent')),
    deg = 360*percent/100;
  if (percent > 50) {
    $ppc.addClass('gt-50');
  }
  $('.ppc-progress-fill').css('transform','rotate('+ deg +'deg)');
  $('.ppc-percents span').html(percent+'%');
  if (percent == 100) {
    $(".progress-pie-chart").css("background-color","#86b332");
    $(".gq-dashboard-points-in-percent").css("color","#86b332");
  }
});

$( "#view_terms" ).click(function() {
    $.ajax({url:"updateCondition",success:function(result){
    }}); 
});

$(".modalClass").click(function () {
    t = this.id;
});
$("#qclose").click(function () {
    $(location).attr('href','qualificationDetails/'+t);
});

$(".checkmark-icon").click(function () {
   var c = confirm("Do yo want to change the status of elective unit ?");
   if (c == true) {
        var unitId = $(this).attr("unit_id");
        var courseCode = $(this).attr("course_code");
        var userId = $(this).attr("user_id");
        $.ajax({
            type: "POST",
            url: "../updateUnitElective",
            data: { unitId: unitId, courseCode: courseCode, userId: userId },
            success:function(result) {
                var label = $( "#label_"+unitId ).attr("temp");
                if (result == '0') {
                    $( "#label_"+unitId ).attr("for","");
                    //$( "#btnadd_"+unitId ).attr("data-model","");
                    //$( "#btnadd_"+unitId ).attr("data-toggle","");
                    $( "#btnadd_"+unitId ).attr('disabled','disabled');
                    $( "#div_"+unitId ).addClass( "gq-acc-row-checked" );
                    $( "#span_"+unitId ).removeClass( "radioUnChecked" );
                    
                } else {
                    $( "#label_"+unitId ).attr("for",label);
                    //$( "#btnadd_"+unitId ).attr("data-model","model");
                    //$( "#btnadd_"+unitId ).attr("data-toggle","model");
                    $( "#btnadd_"+unitId ).removeAttr('disabled');
                    $( "#div_"+unitId ).removeClass( "gq-acc-row-checked" );
                    $( "#span_"+unitId ).addClass( "radioUnChecked" );
                }
            }
        });
   }
});

$(".fromBottom").click(function () {
    unit = $(this).attr("unitid");
    $('#file_hid_unit').val(unit);
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
   var c = confirm("Do yo want to delete selected file ?");
   if (c == true) {
        var fid = $(this).attr("fileid");
        var ftype = $(this).attr("filetype");
        $.ajax({
            type: "POST",
            url: "deleteEvidenceFile",
            data: { fid: fid, ftype: ftype },
            success:function(result) {
                $('#evd_'+fid).hide();
                alert("Selected Evidence File deleted!");
            }
        });
   }
});

$(".deleteIdFiles").click(function () {
   var c = confirm("Do yo want to delete selected file ?");
   if (c == true) {
        var fid = $(this).attr("fileid");
        var ftype = $(this).attr("filetype");
        $.ajax({
            type: "POST",
            url: "deleteIdFiles",
            data: { fid: fid, ftype: ftype },
            success:function(result) {
                $('#idfiles_'+fid).hide();
                alert("Selected ID File deleted!");
            }
        });
   }
});


$("#frmAddEvidence").ajaxForm({
    beforeSubmit: function() {
        $('#file_save').hide();
    },
    success: function(responseText, statusText, xhr, $form) {
        $('.gq-dashboard-tabs').hide();
        $('#gq-dashboard-tabs-success').show();
		if (responseText == '0') {
			$('#gq-dashboard-tabs-success').html('<span></span><h2>Evidence upload successfully!</h2>');
		} else {
			$('#gq-dashboard-tabs-success').html('<span></span><h2>File size below 10MB id upload successfully!</h2>');
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
        $('#gq-dashboard-tabs-success').html('<span><h2>Existing Evidence upload successfully!</h2></span>');
    },
    resetForm: true
});


$("#evd_close").click(function () {
    //location.reload();
});

function validatefile()
{    
}

function validateExisting()
{
    var efile = $(".check_evidence:checkbox:checked").length;
    if(efile <= 0 || efile == '' || typeof  efile === 'undefined') {
        alert('Please select atleast one Existing Evidence!');
        return false;
    }
}