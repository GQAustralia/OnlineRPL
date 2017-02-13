$(document).ready(function(){
	UPLOAD_ICON_ANIMATION.build();
})

// Profile page upload icon animation
var UPLOAD_ICON_ANIMATION = {
    elem: $('#uploadAvatar'),
    animate: function(scale_value) {
            this.elem.next('i').velocity({scale: scale_value}, 200)
    },
    hover: function() {
        $('#userprofile_userImage').on('change', function(){
            $("#ajax-loading-icon").show();
            var userId = $('#hdn-userId').val(), userType = $('#hdn-type').val(), fileName = $(this).val(), Extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
            if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {        
                var file_data = $('#userprofile_userImage').prop('files')[0], form_data = new FormData();
                form_data.append('file', file_data);
                profileImageUpload();
            }
            else
            {
                $("#profile_suc_msg2").hide();
                $("#ajax-profile-error").show();
                $("#ajax-profile-error").html('<div class="gq-id-files-upload-error-text alert alert-danger"><h2>Please upload valid image</h2></div>');
                return false;
            }
        })
    },
    build: function() {UPLOAD_ICON_ANIMATION.hover();}
}
