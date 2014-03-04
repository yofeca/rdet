var base_url = location.protocol + "//" + location.hostname + "/rdet/";
var display_id = 0, dup_id = 0, action = '';

jQuery(document).ready(function() {
    populate_fields();
    lock_fields(true);
    event('');
    populate_jquery_grid();
    
    jQuery('#logout').button({icons: {primary: "ui-icon-power"}, text: false}).click(function(){ window.location.href = base_url + 'admin/logout'});
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
                        pid: $('#pid').val(),
                        uname: $('#e-a-username').val(),
                        pword: $('#e-a-password1').val()
                    }, success: function(response) {
                        if (response.error) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                              display_id = $('#pid').val();
                              $('#list').trigger( 'reloadGrid' );
                              clear_fields();
                              populate_fields();
                              lock_fields(true);
                              event('save');                        
                        }
                        $('#edit-account-dialog').dialog("close");
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
    
    $("#update-user-account").click(function() {
                $("#e-a-username").val($("#username").val());
                $("#e-a-password1").val($("#password1").val());
                $("#e-a-password2").val('');
                $('.validate-error').html('');
                $("#edit-account-dialog").dialog("open");
                $("#e-a-password2").focus();
            });
            
    jQuery('#employee_id').bind('blur', function(){
        if(action == 'new'){
            jQuery.post(
                base_url+'admin/async_employee_id', { emp_id: jQuery('#employee_id').val() },
                function(response){
                    if(response.err){
                        jQuery('#employee_id').css("border", "1px solid #FF0000").css("background", "#FAEBD7");
                        alert('ID Number already exists.');
                        jQuery('#employee_id').focus();
                        dup_id = 1;
                    }else{
                        jQuery('#employee_id').css("border", "1px solid #AAAAAA").css("background", "#FFFFFF");
                        dup_id = 0;
                    }
                },"json"  
            );
        }
    });
    
    jQuery('#birth_date').datepicker({
            changeMonth: true,
            changeYear: true
        });
        
    jQuery('#new').button({icons: {primary: "ui-icon-document"} ,text: true})
            .click(function(){
                action = 'new';
                display_id = 0;
                lock_fields(false);
                event('new');
                clear_fields();
                jQuery('#pid').val('0');
                jQuery('input[name=employee_id]').focus();
            });
            
    jQuery("#dialog-confirm-delete").dialog({
        autoOpen: false,
        resizable: false,
        width: 400,
        modal: true,
        buttons: {
            "Ok": function() {
                $.post( base_url + 'admin/async_delete_account',
                    { pid: jQuery('#pid').val() },
                        function(response){
                            alert('The account is successfully deleted');
                            window.location.href = base_url + 'admin/manage_accounts';
                        }
                    );
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });
    
    jQuery('#delete').button({icons: {primary: "ui-icon-trash"} ,text: true}).click(function(){
        jQuery('#dialog-confirm-delete').dialog("open");
    });
    
    jQuery('#save').button({icons: {primary: "ui-icon-disk"} ,text: true})
            .click(function() {
                    var allFields = jQuery([]).add(employee_id).add(first_name).add(middle_name)
                            .add(last_name).add(birth_date).add(sex).add(address)
                            .add(username).add(password1).add(password2).add(usertype),
                            act = 0, pr = 0;
                            if(jQuery("input[name='usertype']:checked").val()) pr = jQuery("input[name='usertype']:checked").val();
                            if(jQuery("input[name='active']:checked").val()) act = 1;
                            
                    allFields.css("border", "1px solid #AAAAAA").css("background", "#FFFFFF");
                    
                    var params = {
                        type: 'POST',
                        url: base_url + 'admin/async_save_account',
                        dataType: 'json',
                        data: {
                            pid: jQuery('#pid').val(),
                            emp_id: jQuery('#employee_id').val(),
                            fname: jQuery('#first_name').val(),
                            mname: jQuery('#middle_name').val(),
                            lname: jQuery('#last_name').val(),
                            bdate: jQuery('#birth_date').val(),
                            sex: jQuery("input[name='sex']:checked").val(),
                            addr: jQuery('#address').val(),
                            uname: jQuery('#username').val(),
                            pword1: jQuery('#password1').val(),
                            pword2: jQuery('#password2').val(),
                            privilege: pr,
                            active: act,
                            action: action
                        },
                        success: function(response) {
                            if (response.error) {
                                alert(response.message);
                                jQuery('#' + response.field).focus().css("border", "1px solid red").css("background", "#FAEBD7");
                            } else {
                                  display_id = response.pid;
                                  $('#list').trigger( 'reloadGrid' );
                                  clear_fields();
                                  populate_fields();
                                  lock_fields(true);
                                  event('save');
                            }
                        }
                    }
                    jQuery.ajax(params);
            });
    
    jQuery('#edit').button({icons:{ primary: "ui-icon-pencil" }, text: true})
            .click(function(){
                action='edit';
                display_id = jQuery('#pid').val();
                lock_fields(false);
                event('edit');
            });


    jQuery('#cancel').button({icons:{ primary: "ui-icon-refresh" }, text: true})
            .click(function(){
                if(jQuery('#pid').val() == 0 ) display_id = 0;
                else display_id = jQuery('#pid').val();
                clear_fields();
                populate_fields();
                event('cancel');
                lock_fields(true);
            });
            
    jQuery("#xy_list")
        .jqGrid('navGrid', '#xy_list_pager', { edit : false, add : false, del : false, search : false })
        .jqGrid('filterToolbar',{ stringResult: true, searchOnEnter: true, defaultSearch : 'eq' });

    //jQuery('div#order_listing-wrapper').fixedCenter();

});

function clear_fields(){
    jQuery('#employee_id').val('');
    jQuery('#first_name').val('');
    jQuery('#middle_name').val('');
    jQuery('#last_name').val('');
    jQuery('#birth_date').val('');
    jQuery('input[name=sex]').removeAttr("disabled");
    jQuery('input[name=sex]').removeAttr("checked");
    jQuery('#address').val('');
    
    if(action == 'new'){
        jQuery('#username').val('');
        jQuery('#password1').val('');
        jQuery('#password2').val('');
    }
    
    jQuery('input[name=usertype]').removeAttr("disabled");
    jQuery('input[name=usertype]').removeAttr("checked");
    jQuery('input[name=active]').removeAttr("disabled");
    jQuery('input[name=active]').removeAttr("checked");
}

function lock_fields(c) {
    jQuery('#employee_id').attr("disabled", c);
    jQuery('#first_name').attr("disabled", c);
    jQuery('#middle_name').attr("disabled", c);
    jQuery('#last_name').attr("disabled", c);
    jQuery('#birth_date').attr("disabled", c);
    jQuery('input[name=sex]').attr("disabled", c);
    jQuery('#address').attr("disabled", c);

    if(action == 'new'){
        jQuery('#username').attr("disabled", c);
        jQuery('#password1').attr("disabled", c);
        jQuery('#password2').attr("disabled", c);
    }
    
    if(action == 'edit' || action == ''){
        jQuery('#username').attr("disabled", true);
        jQuery('#password1').attr("disabled", true);
    }
    
    jQuery('input[name=usertype]').attr("disabled", c);
    jQuery('input[name=active]').attr("disabled", c);
}

function event(e){
    switch(e){
        case 'new':
            jQuery('#new').hide(); jQuery('#delete').hide(); jQuery('#edit').hide(); jQuery('#save').show(); jQuery('#cancel').show();
            jQuery('#update-user-account').hide(); jQuery('#display-password2').show();
            break;
        case 'edit':
            jQuery('#new').hide(); jQuery('#delete').hide(); jQuery('#edit').hide(); jQuery('#save').show(); jQuery('#cancel').show();
            jQuery('#update-user-account').show(); jQuery('#display-password2').hide();
            break;
        case 'cancel':  case 'save':
            jQuery('#new').show(); jQuery('#delete').show(); jQuery('#save').hide(); jQuery('#edit').show(); jQuery('#cancel').hide();
            jQuery('#update-user-account').show(); jQuery('#display-password2').hide();
            break;
        default:
            jQuery('#new').show(); jQuery('#delete').show(); jQuery('#edit').show(); jQuery('#save').hide(); jQuery('#cancel').hide();
            jQuery('#update-user-account').show(); jQuery('#display-password2').hide();
    }
}

function populate_jquery_grid(){
        jQuery("#list").jqGrid({
        width       : 800,
        height      : 245,
        url         : base_url + 'admin/async_accounts',
        datatype    : 'json',
        colNames    : [ 'ID',
                        'Employee ID',
                        'First Name',
                        'Middle Name',
                        'Last Name',
                        'Privilege',
                        'Active'
                      ],
        colModel    : [ { name : '', index : '', width : 30, fixed : true, align : 'right', sortable : true, resizable : false, search : false },
                        { name : '', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
                        { name : '', index : '', width : 150, fixed : true, align : 'left', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 150, fixed : true, align : 'left', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 150, fixed : true, align : 'left', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 100, fixed : true, align : 'center', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 60, fixed : true, align : 'center', sortable : false, resizable : false, search : false }
                      ],
        rowNum      : 10,
        pager       : '#list_pager',
        rowList: [10,20,30],
        sortname    : '',
        viewrecords : true,
        sortorder   : 'desc',
        caption     : 'RDET User Accounts',
        onSelectRow : function(pid){
            display_id = pid;
            fetch_field_data();
        }
    });
    jQuery("#list").jqGrid('navGrid','#list_pager',{edit:false,add:false,del:false,search:false});
}

function populate_fields() {
    if(display_id == 0)
        jQuery.post(base_url + 'admin/async_fetch_person_id', 
                function(response){ 
                    display_id = response.pid;
                    fetch_field_data();
                },
                "json" );
    else
        fetch_field_data();
}

function fetch_field_data(){
        jQuery.post(base_url + 'admin/async_get_account', { pid: display_id },
            function(response) {
                if (!response.err) {
                    
                    var s = [];
                    s['MALE'] = 'FEMALE';
                    s['FEMALE'] = 'MALE';
                    
                    var ut = [];
                    ut['1'] = '2';
                    ut['2'] = '1';
                                        
                    jQuery('#pid').val(response.pid);
                    jQuery('#employee_id').val(response.emp_id);
                    jQuery('#first_name').val(response.fname);
                    jQuery('#middle_name').val(response.mname);
                    jQuery('#last_name').val(response.lname);
                    jQuery('#birth_date').val(response.bdate)
                    
                    jQuery("input[name='sex'][value='" + response.sex.toUpperCase() + "']").attr("checked", true);
                    jQuery("input[name='sex'][value='" + s[response.sex.toUpperCase()] + "']").removeAttr('checked');
                    
                    jQuery('#address').val(response.addr);
                    jQuery('#username').val(response.uname);
                    jQuery('#password1').val('qwerty');
                    
                    jQuery("input[name='usertype'][value='" + response.privilege + "']").attr('checked', true);
                    jQuery("input[name='usertype'][value='" + ut[response.privilege] + "']").removeAttr('checked');
                    
                    if(response.active == 1)
                        jQuery("input[name='active']").attr('checked', true);
                    else
                        jQuery("input[name='active']").removeAttr('checked');
                }
            }, "json"
        );
}