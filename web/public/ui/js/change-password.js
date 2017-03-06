var SET_PASSWORD = {
    oldPassword: $('#oldPassword'),
    password: $('#password'),
    confirm_password: $('#confirmPassword'),
    button: $('#submitPassword'),
    error: $('#errorMessage'),
    errormsg: $('#errorMessage span'),
    bind: function(){
        this.button.on('click', function(){SET_PASSWORD.validate_fields()});
        $('#oldPassword, #password, #confirmPassword').on('change', function(){SET_PASSWORD.validate_empty_fields();})
    },
    submit_enter: function () {
        $(document).on('keyup', '#oldPassword, #password, #confirmPassword', function (event) {
            if (event.keyCode == 13) {
                SET_PASSWORD.validate_fields();
            }
        });
    },
    validate_empty_fields: function(){
        if(checkEmptyField(SET_PASSWORD.password) === 'valid' && checkEmptyField(SET_PASSWORD.confirm_password) === 'valid'){ this.button.prop('disabled', false)}
        else{this.button.prop('disabled', true)}

        function checkEmptyField(elem){
            var validity = 'invalid';
            if(elem.val().length){
                validity = 'valid';
            }else{
                validity = 'invalid';
            }
            return validity;
        }
    },
    validate_fields: function () {
        var password = SET_PASSWORD.password.val();
        if (checkCharacters() === 'valid') {
            if (isPasswordMatch() === 'valid') {
                    SET_PASSWORD.submit_password();
            } else {
                SET_PASSWORD.error_action('Passwords do not match.')
            }
        } else {
            SET_PASSWORD.error_action('Your password must be at least 8 characters')
        }

        // check for spaces and password length
        function checkCharacters() {
            var pattern = /\s/g,
                field_has_space = pattern.test(password),
                validity = 'invalid';

            if (password.length >= 8) {
                if (field_has_space === false) {
                    validity = 'valid';
                } else {
                    SET_PASSWORD.error_action('Your password must not contain spaces')
                    validity = 'invalid'
                }
            } else {
                validity = 'invalid';
            }
            return validity;
        }

        // check if password field matches with confirm password field
        function isPasswordMatch() {
            var confirm_password = SET_PASSWORD.confirm_password.val(),
                validity = 'invalid';

            if (password === confirm_password) {
                validity = 'valid'
            }
            else {
                validity = 'invalid';
            }

            return validity;
        }
    },
    submit_password: function () {
        var oldPassword = SET_PASSWORD.oldPassword.val(),
            password = SET_PASSWORD.password.val(),
            confirm_password = SET_PASSWORD.confirm_password.val(),
            btntext = '<i class="zmdi zmdi-settings zmdi-hc-spin"></i> Setting Password';
         
        SET_PASSWORD.button.attr('disabled', true).html(btntext);
        oldPwdValidation = SET_PASSWORD.check_currPwd(oldPassword);
        if(oldPwdValidation === 'fail')
        {
            SET_PASSWORD.error_action('Passwords do not match');
            SET_PASSWORD.button.attr('disabled', false).html('Set Password');
            return false;
        }
        if (oldPassword === password) {
            SET_PASSWORD.error_action('Your new password must not be the same with your old password');
            SET_PASSWORD.button.attr('disabled', false).html('Set Password');
            return false;
        }
        $.ajax({
                url: base_url+"updatepasswordAjax",
                type: 'POST',
                cache: false,
                data: { 'password_newpassword' : password }
        })
        .success(function(data) {
                SET_PASSWORD.error_action('Password successfully updated.');
                $('#errorMessage').removeClass('alert-danger').addClass('alert-success');
                SET_PASSWORD.button.attr('disabled', false).html('Set Password');
                SET_PASSWORD.oldPassword.val('');
                SET_PASSWORD.password.val('');
                SET_PASSWORD.confirm_password.val('');
        })
        .fail(function() { 
                SET_PASSWORD.error_action('Could not connect to server.');
                SET_PASSWORD.button.attr('disabled',false).html('Set Password');
        })
    },
    check_currPwd: function(oldPwd) {
        if(oldPwd !== null) {
            var pswd_validation = $.parseJSON($.ajax({
                type: "POST",
                url:  'checkMyPassword',
                dataType: "json", 
                async: false,
                data: {mypassword: oldPwd}
            }).responseText);
                return pswd_validation['status'];
            }
    },
    error_action: function (error_msg) {
        var errormsg = SET_PASSWORD.errormsg,
            error = SET_PASSWORD.error;

        error.removeClass('hidden');
        errormsg.html(error_msg);
        SET_PASSWORD.button.velocity('callout.shake');
    },
    reset_fields: function(){
        modal = $('#editPassword');
        modal.on('hidden.bs.modal', function(){
            modal.find('form')[0].reset();
            SET_PASSWORD.error.addClass('hidden').find('span').html(' ')
        })
    },
    build: function () {
        this.bind();
        this.submit_enter();
        SET_PASSWORD.reset_fields();
    }
}

$(document).ready(function () {
    TOGGLE_PASSWORD.build();
    SET_PASSWORD.build();
//    LOGIN.build();
//    AUTH.build();
});