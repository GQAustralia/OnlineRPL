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
					$( "#btnadd_"+unitId ).attr("data-model","");
                    $( "#div_"+unitId ).addClass( "gq-acc-row-checked" );
					$( "#span_"+unitId ).removeClass( "radioUnChecked" );
					
                } else {
					$( "#label_"+unitId ).attr("for",label);
					$( "#btnadd_"+unitId ).attr("data-model","model");
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
});

$("#frmSelectEvidence").submit(function () {
	 $('#select_hid_unit').val(unit);
});