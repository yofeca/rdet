var base_url = location.protocol + "//" + location.hostname + "/rdet/";

jQuery(document).ready(function() {
    jQuery('#logout').button({icons: {primary: "ui-icon-power"}, text: false}).click(function(){ window.location.href = base_url + 'admin/logout'});
    lock_profile_fields();
    lock_account_fields();
    
    $('#save').hide();
    $('#cancel').hide();
    
    $('#birth_date').datepicker({
            changeMonth: true,
            changeYear: true
        });
    
    $('#edit-account-dialog').dialog({
        autoOpen: false,
        width: 335,
        modal: true,
        buttons: {
            "Save": function() {
                if($('#e-a-username').val().length < 3){
                    $('.validate-error').html('Username length must not be less than 3 characters.');
                }else if($('#e-a-password1').val().length < 5){
                    $('.validate-error').html('Password length must not be less than 5 characters.');
                }else if($('#e-a-password1').val() != $('#e-a-password2').val()){
                    $('.validate-error').html('Password does not match.');
                }else{
                    var params = {
                    type: 'POST',
                    url: base_url + 'admin/async_update_user_account',
                    dataType: 'json',
                    data: {
                        uid: $('#uid').val(),
                        uname: $('#e-a-username').val(),
                        pword: $('#e-a-password1').val()
                    }, success: function(response) {
                        if (response.error) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                            window.location.href = base_url + 'admin/myprofile/' +$('#uid').val();
                        }
                    }
                };
                jQuery.ajax(params);
                }
            },
            "Cancel": function(){
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
    
    $("#edit-account")
            .button({icons: {primary: "ui-icon-pencil" }})
            .click(function() {
                $("#e-a-username").val($("#username").val());
                $("#e-a-password1").val($("#password").val());
                $("#e-a-password2").val('');
                $('.validate-error').html('');
                $("#edit-account-dialog").dialog("open");
                $("#e-a-password2").focus();
            });

    $('#save').button()
            .click(function() {
                var params = {
                    type: 'POST',
                    url: base_url + 'admin/update_myprofile',
                    dataType: 'json',
                    data: {
                        pid: $('#pid').val(),
                        uid: $('#uid').val(),
                        emp_id: $('#employee_id').val(),
                        fname: $('#first_name').val(),
                        mname: $('#middle_name').val(),
                        lname: $('#last_name').val(),
                        bdate: $('#birth_date').val(),
                        sex: $('#sex').val(),
                        addr: $('#address').val()
                    },
                    success: function(response) {
                        if (response.error) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                            window.location.href = base_url + 'admin/myprofile/' +$('#uid').val();
                        }
                    }
        }
        
        $.ajax(params);
    });
    
    $('#edit').button({icons:{ primary: "ui-icon-pencil" }, text: true})
            .click(function(){
                unlock_profile_fields();
                $('#employee_id').focus();
                $('#save').show();
                $('#cancel').show();
                $('#edit').hide();

            });


    $('#cancel').button({icons:{ primary: "ui-icon-refresh" }, text: true})
            .click(function(){
                window.location.href = base_url + 'admin/myprofile/' + $('#uid').val();
            });
    

});
    
function lock_profile_fields() {
    jQuery('#employee_id').attr("disabled", "disabled");
    jQuery('#first_name').attr("disabled", "disabled");
    jQuery('#middle_name').attr("disabled", "disabled");
    jQuery('#last_name').attr("disabled", "disabled");
    jQuery('#birth_date').attr("disabled", "disabled");
    jQuery('#sex').attr("disabled", "disabled");
    jQuery('#address').attr("disabled", "disabled");
}

function unlock_profile_fields() {
    jQuery('#employee_id').removeAttr("disabled");
    jQuery('#first_name').removeAttr("disabled");
    jQuery('#middle_name').removeAttr("disabled");
    jQuery('#last_name').removeAttr("disabled");
    jQuery('#birth_date').removeAttr("disabled");
    jQuery('#sex').removeAttr("disabled");
    jQuery('#address').removeAttr("disabled");
}

function lock_account_fields() {
    jQuery('#username').attr("disabled", "disabled");
    jQuery('#password').attr("disabled", "disabled");
}

function unlock_account_fields() {
    jQuery('#username').removeAttr("disabled");
    jQuery('#password').removeAttr("disabled");
}