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