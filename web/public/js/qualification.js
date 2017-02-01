$(document).ready(function(){
	//to show the profile popup
	$(".profile-popup").on("click", function(){

		var profileData = $(this).data();
		if (profileData.acctype != 'Account Manager') {
			$('.profile-message').hide();
		}
		else{
			$('.profile-message').show();
		}
		$('.profile-img').attr('src', profileData.imgsrc);
		$('.profile-name').html(profileData.name);
		$('.profile-type').html(profileData.acctype);
		$('.profile-email').html(profileData.email);
		$('.profile-phone').html(profileData.phone);
    });
});