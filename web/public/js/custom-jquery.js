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
            success:function(result){
                if (result == '0') {
                    $( "#div_"+unitId ).addClass( "gq-acc-row-checked" );
                } else {
                    $( "#div_"+unitId ).removeClass( "gq-acc-row-checked" );
                }
            }
        });
   }
});

$(".fromBottom").click(function () {
    var unit = $(this).attr("unitid");
    $('#hid_unit').val(unit);
});
