var AUTH = {
    doc: $(document),
    username: $('#username'),
    password: $('#currentpassword'),
    button: $('#submitAuth'),
    error: $('#errorMessage'),
    errormsg: $('#errorMessage span'),
    rememberMe: $('#rememberCredential'),

    bind: function () {
        this.doc.on('click', '#submitAuth', AUTH.validate_fields);
        this.doc.on('click', '#logoutUser', AUTH.log_out);

        this.doc.on('click', '#rememberCredential', AUTH.remember_me);

        $('#userAccountName').html(localStorage.getItem('name'));

        this.doc.on('blur', '#username', AUTH.remember_me);
        this.doc.on('blur', '#currentpassword', AUTH.remember_me);
    },
    submit_enter: function () {
        $(document).on('keyup', '#username, #currentpassword', function (event) {
            if (event.keyCode == 13) {
                AUTH.validate_fields();
                AUTH.remember_me();
            }
        });
    },
    check_if_remembered: function () {
        var stored_username = localStorage.getItem('fsrusername'),
            stored_password = localStorage.getItem('fsrpassword');

        if ((stored_username !== null && stored_password !== null) || (AUTH.username.val() !== '' && AUTH.password.val() !== '')) {
            AUTH.username.val(stored_username);
            AUTH.password.val(stored_password);
            AUTH.rememberMe.prop('checked', true);
        }
        else {
            AUTH.username.val('');
            AUTH.password.val('');
            AUTH.rememberMe.prop('checked', false);
        }
    },
    remember_me: function () {
        function checked() {
            localStorage.setItem('fsrusername', AUTH.username.val());
            localStorage.setItem('fsrpassword', AUTH.password.val());
        }

        function unchecked() {
            localStorage.removeItem('fsrusername');
            localStorage.removeItem('fsrpassword');
        }

        if (AUTH.rememberMe.is(':checked')) {
            checked();
        }
        else {
            unchecked();
        }
    },
    validate_fields: function () {
        if (areFieldsValid() === 'valid') {
            AUTH.log_in();
        }
        else {
            AUTH.error.removeClass('hidden');
            AUTH.button.velocity('callout.shake');
        }

        function areFieldsValid() {
            var validity = 'invalid',
                pattern = /\s/g,
                email_pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                user_has_space = pattern.test(AUTH.username.val()),
                pass_has_space = pattern.test(AUTH.password.val());
            email_format = email_pattern.test(AUTH.username.val());

            if (AUTH.username.val().length > 0 && email_format === false) {
                AUTH.errormsg.html('Incorrect email format');
                validity = 'invalid';
            }
            else if (AUTH.username.val().length > 0 && AUTH.password.val().length > 0 && email_format !== false) {
                if (user_has_space === false && pass_has_space === false) {
                    validity = 'valid';
                }
                else {
                    AUTH.errormsg.html('Login credentials should not have spaces.');
                    validity = 'invalid';
                }
            }
            else {
                AUTH.errormsg.html('Login credentials should not be left blank.');
                isValid = 'invalid';
            }
            return validity;
        }
    },
    log_in: function () {

        var username = AUTH.username.val(),
            password = AUTH.password.val();

        var btntext = '<i class="zmdi zmdi-settings zmdi-hc-spin"></i> Logging in...';

        AUTH.button.attr('disabled', true).html(btntext);
    },

    log_out: function () {
        var token = localStorage.getItem('token');

        $.ajax({
            url: UTILS.url('logout'),
            type: 'GET',
            data: {"token": token}
        })
            .always(function () {
                localStorage.removeItem('token');
                localStorage.removeItem('fsrid');
                // window.location.replace('index.html');
            })
    },
    get_name: function () {
        var name = localStorage.getItem('name');

        $('#userAccountName').html(name);
    },
    build: function () {
        this.bind();
        this.submit_enter();
        this.check_if_remembered();
    }
}

var SET_PASSWORD = {
    oldPassword: $('#oldPassword'),
    password: $('#password'),
    confirm_password: $('#confirmPassword'),
    button: $('#submitPassword'),
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
                SET_PASSWORD.error_action('Password do not match.')
            }
        } else {
            SET_PASSWORD.error_action('Password must be minimum of 8 characterski.')
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
                    SET_PASSWORD.error_action('Password must not contain spaces')
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
            SET_PASSWORD.error_action('Current password does not match.');
            SET_PASSWORD.button.attr('disabled', false).html('Set Password');
            return false;
        }
        if (oldPassword === password) {
            SET_PASSWORD.error_action('Current Password and New Password must be different.');
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
                SET_PASSWORD.error_action('Password updated successfully.');
                $('#errorMessage').removeClass('alert-danger').addClass('alert-success');
//                SET_PASSWORD.button.attr('disabled', false).html('Set Password');
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
        var errormsg = AUTH.errormsg,
            error = AUTH.error;

        error.removeClass('hidden');
        errormsg.html(error_msg);
        SET_PASSWORD.button.velocity('callout.shake');
    },
    build: function () {
        this.bind();
        this.submit_enter();
    }
}

$(document).ready(function () {
    TOGGLE_PASSWORD.build();
    SET_PASSWORD.build();
//    LOGIN.build();
//    AUTH.build();
});