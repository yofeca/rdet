var base_url = location.protocol + "//" + location.hostname + "/rdet/";
var cat = 0, action = '';

//populate_html();

jQuery(document).ready(function(){
    var fname = jQuery("#adf-first-name"),
    mname = jQuery("#adf-middle-name"),
    lname = jQuery("#adf-last-name"),
    sex = 0,
    au_type = jQuery("#adf-sel-type"),
    allFields = jQuery([]).add(fname).add(mname).add(lname),
    tips = jQuery("#validateTips");
    
    search_author_autocomplete();
    
    populate_jquery_grid();
    
    jQuery('#user-search-box select').bind("change", function(){
        cat = $('#user-search-box select').val();
    });
    
    function checkLength(o, n, min, max) {
        if (o.val().length > max || o.val().length < min) {
            o.addClass("ui-state-error");
            updateTips(n + " must not be less than " + min + " characters.");
            return false;
        } else {
            return true;
        }
    }

    function checkRegexp(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            updateTips(n);
            return false;
        } else {
            return true;
        }
    }

    function updateTips(t) {
        tips
                .text(t)
                .addClass("ui-state-highlight");
        setTimeout(function() {
            tips.removeClass("ui-state-highlight", 1500);
        }, 500);
    }
    
    jQuery('#confirm-remove-book').dialog({ autoOpen: false });
    jQuery('#confirm-delete-author').dialog({ autoOpen: false });
    jQuery('#add-research-title').dialog({ autoOpen: false, model: true});
    
    jQuery('#logout').button({icons: {primary: "ui-icon-power"}, text: false}).click(function(){ window.location.href = base_url + 'admin/logout'});
    
    jQuery('#new')
            .button({icons: {primary: "ui-icon-document"}})
            .click(function(){
                action = 'new';
                jQuery('#author-dialog-form').dialog("open");
                clear_author_dialog_fields();
                clear_other_info_errors();
            });
    
    jQuery('#edit')
            .button({icons: {primary: "ui-icon-pencil"}})
            .click(function(){
                action = 'edit';
                jQuery('#author-dialog-form').dialog("open");
                edit_author_dialog_fields();
            });
    
    jQuery('#delete')
            .button({icons: {primary: "ui-icon-trash"}})
            .click(function(){
                jQuery('#confirm-delete-author').dialog({ 
                   autoOpen: true,
                   modal: true,
                   buttons: {
                       "Yes": function(){
                           jQuery.ajax({
                               type: 'post',
                               url: base_url + 'author/async_delete_author',
                               dataType: 'json',
                               data: {
                                   auid: jQuery('#auid').val(),
                                   pid: jQuery('#pid').val()
                               },
                               success: function(response){
                                   if(response.err){
                                       display_success_dialog(response.msg);
                                       jQuery('#confirm-delete-author').dialog("close");
                                   }else{
                                       jQuery('#confirm-delete-author').dialog("close");
                                        window.location.href = base_url + 'author';                                  
                                   }
                               }
                           });
                       },
                       "No": function(){
                           jQuery(this).dialog("close");
                       }
                   },
                   close: function(){
                       jQuery(this).dialog("close");
                   }
                });
            });
            
    jQuery('#add-title')
            .button({icons: {primary: "ui-icon-note"}})
            .click(function(){
                jQuery('#add-research-title').dialog({
                    autoOpen: true,
                    modal: true,
                    buttons: {
                        "Add": function(){
                            
                            jQuery(this).dialog("close");
                        },
                        "Close": function(){
                            jQuery(this).dialog("close");
                        }
                    },
                    open: function(){
                            jQuery("input[name='research-title']").val('');
                            search_title_autocomplete();
                    },
                    close: function(){
                        jQuery(this).dialog("close");
                    }  
                });
            });
    
    jQuery('#author-dialog-form').dialog({
        autoOpen: false,
        modal: true,
        buttons:{
            "Save": function(){
                var bValid = true;
                allFields.removeClass("ui-state-error");

                bValid = bValid && checkLength(fname, "First Name", 2, 30);
                bValid = bValid && checkLength(lname, "Last Name", 2, 30);

                bValid = bValid && checkRegexp(fname, /^[a-z]([0-9a-z_])+$/i, "First name may consist of a-z, 0-9, underscores, begin with a letter.");
                bValid = bValid && checkRegexp(lname, /^[a-z]([0-9a-z_])+$/i, "Last name may consist of a-z, 0-9, underscores, begin with a letter.");

                if (bValid) {
                    sex = jQuery("input[name='adf_sex']:checked").val();
                    if (!sex){
                        updateTips("Please select sex.");
                        clear_other_info_errors('sex');
                    } else if (au_type.val() == 0) {
                        updateTips("Please select user type.");
                        clear_other_info_errors('aut');
                    } else {
                        if(action == 'new'){
//                            url = base_url + 'author/async_insert_author';
                            pid = 0;
                        } else if(action == 'edit'){
//                            url = base_url + 'author/async_update_author';
                            pid = jQuery('#pid').val();
                        } else
                            alert('error');
                            
                        jQuery.ajax({
                            type: 'post',
                            url: base_url + 'author/async_i_o_u_author',
                            dataType: 'json',
                            data: {
                                id: pid,
                                fname: jQuery("#adf-first-name").val(),
                                mname: jQuery("#adf-middle-name").val(),
                                lname: jQuery("#adf-last-name").val(),
                                sex: jQuery("input[name='adf_sex']:checked").val(),
                                type: jQuery("#adf-sel-type :selected").val()
                            },
                            success: function(response){
                                display_success_dialog("Successfully updated the database.");
                                populate_field_data(response.id);
                                populate_author_published_books(response.id);
                            }
                        });
                    jQuery(this).dialog("close");
                    }
                }
            },
            "Cancel": function(){
                jQuery(this).dialog("close");
            }
        },
        close: function(){
            jQuery(this).dialog("close");
        }
    });
});

//----Functions----------------------------------------------------------------

function populate_jquery_grid(){
        jQuery("#author-list").jqGrid({
        width       : 800,
        height      : 130,
        url         : base_url + 'author/async_jq_grid_authors',
        datatype    : 'json',
        colNames    : [ 'ID',
                        'First Name',
                        'Middle Name',
                        'Last Name',
                        'Sex',
                        'Type'
                      ],
        colModel    : [ { name : '', index : '', width : 30, fixed : true, align : 'right', sortable : true, resizable : false, search : false },
                        { name : '', index : '', width : 180, fixed : true, align : 'left', sortable : true, resizable : false, search : false },
                        { name : '', index : '', width : 180, fixed : true, align : 'left', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 180, fixed : true, align : 'left', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 100, fixed : true, align : 'left', sortable : false, resizable : false, search : false },
                        { name : '', index : '', width : 100, fixed : true, align : 'left', sortable : false, resizable : false, search : false }
                      ],
        rowNum      : 5,
        pager       : '#author-list-pager',
//        hidegrid: false,
        sortname    : '',
        viewrecords : true,
        sortorder   : 'desc',
        caption     : 'List of Authors:',
        gridComplete: function(){
            firstrow = jQuery('#author-list tr:nth-child(2)').attr('id');
            populate_field_data(firstrow);
            populate_author_published_books(firstrow);
        },
        onSelectRow : function(person_id){
            populate_field_data(person_id);
            populate_author_published_books(person_id);
        }
    });
    jQuery("#author-list").jqGrid('navGrid','#author-list-pager',{edit:false,add:false,del:false });
}

function populate_field_data(pid){
        jQuery.post(base_url + 'author/async_display_author_details', { pid: pid },
            function(response) {
                    au_id = response.auid
                    jQuery('#auid').val(response.auid);
                    jQuery('#pid').val(response.pid);
                    jQuery('#first_name').val(response.fname);
                    jQuery('#middle_name').val(response.mname);
                    jQuery('#last_name').val(response.lname);
                    jQuery('#sex').val(response.sex);
                    jQuery('#type').val(response.type);
            }, "json"
        );
}

function populate_author_published_books(pid){
    jQuery('#list-pub-books').html('');
    jQuery.post(base_url + 'author/async_author_published_books',{ pid: pid },
        function(data){
            if(jQuery.isEmptyObject(data)){
                  list = '<li style="list-style: none; color: #FF0000;">No Reseach is linked to this Author.</li>';                        
                  jQuery('#list-pub-books').append(list);
              }else{
                  jQuery.each( data, function(k, v){
                        if (v.status == 1){
                             dc = v.date_completed;
                             yp = v.year_published;
                            stat = '<p><i>Completed: </i>' + dc + '<i>&nbsp&nbspPublished: </i>' + yp + '</p>';
                        }else
                            stat = '<p><i>Status: </i>Ongoing</p>';

                            list = '<li id="' + v.id + '"><a href="' + base_url + 'research/preview/'+ v.id + '">' + v.title + '</a><a  id="remove-'+v.id+'" class="remove-research">remove</a>' + stat + '</li>';                        
                            jQuery('#list-pub-books').append(list);

                            jQuery("#remove-"+v.id+"").click(function(){                            
                                jQuery('#confirm-remove-book').dialog({
                                    autoOpen: true,
                                    modal: true, 
                                      buttons:{
                                        "Yes": function(){
                                                $.ajax({
                                                    type: 'post',
                                                    url: base_url + 'author/async_author_remove_published_book',
                                                    data:{
                                                        rid: v.id,
                                                        pid: pid
                                                    },
                                                    dataType: 'json',
                                                    success: function(data) {
                                                        jQuery("#"+v.id+"").remove();
                                                    }
                                                });
                                                jQuery(this).dialog("close");
                                        },
                                        "No": function(){
                                            jQuery(this).dialog("close");
                                        }
                                    },
                                    close: function() {
                                        jQuery(this).dialog("close");
                                    }
                                });
                            });
                  });
              }
         }, "json");
}

//function populate_html(){
//    jQuery.post(base_url + 'author/async_author_pid', function(data){
//        populate_jquery_grid();
//        populate_field_data(data.id);
//        populate_author_published_books(data.id);
//    },"json"); 
//}

function clear_author_dialog_fields(){
    jQuery("#adf-first-name").val('');
    jQuery("#adf-middle-name").val('');
    jQuery("#adf-last-name").val('');
    
    jQuery("input[name='adf_sex']").attr("checked",false);
    jQuery("#adf-sel-type :selected").attr("selected",false);
}

function edit_author_dialog_fields(){
    jQuery("#adf-first-name").val(jQuery("#first_name").val());
    jQuery("#adf-middle-name").val(jQuery("#middle_name").val());
    jQuery("#adf-last-name").val(jQuery("#last_name").val());
    
    var s = [];
    s['MALE'] = 'FEMALE';
    s['FEMALE'] = 'MALE';
                        
    sex = jQuery("#sex").val().toUpperCase();
    type = jQuery("#type").val().toUpperCase();

    jQuery("input[name='adf_sex'][value='" + sex + "']").attr("checked", true);
    jQuery("input[name='adf_sex'][value='" + s[sex] + "']").removeAttr('checked');
    
    if(type == 'FACULTY') jQuery("#adf-sel-type [value='1']").attr("selected",true);
    if(type == 'STUDENT') jQuery("#adf-sel-type [value='2']").attr("selected",true);
    if(type == 'COMMUNITY') jQuery("#adf-sel-type [value='3']").attr("selected",true);
}

function display_success_dialog(info) {
    jQuery('#success').dialog({
        autoOpen: true,
        modal: true,
        buttons: {
            "Ok": function() {
                jQuery(this).dialog("close");
            }
        },
        open: function() {
            jQuery("#success p").html(info);
        },
        close: function() {
            jQuery(this).dialog("close");
        }
    });
}

function clear_other_info_errors(c){
    if (c == 'sex') {
        jQuery('#adf-type').css({"background" : "url('images/ui-bg_glass_95_fef1ec_1x400.png') repeat-x scroll 50% 50% #FFFFFF", "border": "1px solid #AAAAAA"});
        jQuery('#adf-btn-sex').css({"background" : "url('images/ui-bg_flat_75_ffffff_40x100.png') repeat-x scroll 50% 50% #FEF1EC", "border": "1px solid #CD0A0A"});
    } else if (c == 'aut') {
        jQuery('#adf-btn-sex').css({"background" : "url('images/ui-bg_flat_75_ffffff_40x100.png') repeat-x scroll 50% 50% #FFFFFF", "border": "1px solid #AAAAAA"});
        jQuery('#adf-type').css({"background" : "url('images/ui-bg_glass_95_fef1ec_1x400.png') repeat-x scroll 50% 50% #FEF1EC", "border": "1px solid #CD0A0A"});
    } else {
        jQuery('#adf-btn-sex').css({"background": "url('images/ui-bg_flat_75_ffffff_40x100.png') repeat-x scroll 50% 50% #FFFFFF", "border": "1px solid #AAAAAA"});
        jQuery('#adf-type').css({"background": "url('images/ui-bg_flat_75_ffffff_40x100.png') repeat-x scroll 50% 50% #FFFFFF", "border": "1px solid #AAAAAA"});
    }
}

function search_author_autocomplete(){
        jQuery('#search-box').autocomplete({
        source: function(request, response){
            $.ajax({
                    type: 'post',
                    url: base_url + 'author/async_author_autocomplete_box',
                    dataType: 'json',
                    data:{
                        item: request.term,
                        category: cat
                    },
                    success: function(data){
                        if(jQuery.isEmptyObject(data)){
                            jQuery('#search-box').addClass('search-error')
                                                 .addClass('text ui-corner-all');
                        }else{
                           jQuery('#search-box').removeClass('search-error');
                           response($.map(data, function(item){                                   
                                return {
                                    label: item.last_name + ", " + item.first_name,
                                    id: item.id,
                                }
                           }));
                       }
                    }
            });
        },
        minLength: 3,
        select: function( event, ui ) {
                populate_field_data(ui.item.id);
                populate_author_published_books(ui.item.id);
        },
        open: function() {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function() {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
}

function search_title_autocomplete(){
        jQuery("input[name='research-title']").autocomplete({
        source: function(request, response){
            $.ajax({
                    type: 'post',
                    url: base_url + 'author/async_research_title_autocomplete',
                    dataType: 'json',
                    data:{
                        item: request.term,
                    },
                    success: function(data){
                           response($.map(data, function(item){                                   
                                return {
                                    label: item.title,
                                    id: item.id,
                                    status: item.status,
                                    date_completed: item.date_completed,
                                    year_published: item.year_published
                                }
                           }));
                    }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            jQuery.ajax({
                type: 'post',
                url: base_url + 'author/async_autor_insert_research_title',
                dataType: 'json',
                data: {
                    rid: ui.item.id, 
                    pid: jQuery('#pid').val()
                },
                success: function(response){
                    if(response.err)
                        display_success_dialog(response.msg)
                    else
                        populate_research_books(
                        ui.item.id, jQuery('#pid').val(), 
                        ui.item.status, 
                        ui.item.date_completed, 
                        ui.item.year_published, 
                        ui.item.label);
                        
                        jQuery("input[name='research-title']").val('');
                }
            });
        }
    });
}

function populate_research_books(id, pid, s, dc, yp, title){
    if (s == 1){
        stat = '<p><i>Completed: </i>' + dc + '<i>&nbsp&nbspPublished: </i>' + yp + '</p>';
    } else
            stat = '<p><i>Status: </i>Ongoing</p>';

    list = '<li id="' + id + '"><a href="' + base_url + 'research/preview/' + id + '">' + title + '</a><a  id="remove-' + id + '" class="remove-research">remove</a>' + stat + '</li>';
    jQuery('#list-pub-books').append(list);

    jQuery("#remove-" + id + "").click(function() {
        jQuery('#confirm-remove-book').dialog({
            autoOpen: true,
            modal: true,
            buttons: {
                "Yes": function() {
                    $.ajax({
                        type: 'post',
                        url: base_url + 'author/async_author_remove_published_book',
                        data: {
                            rid: id,
                            pid: pid
                        },
                        dataType: 'json',
                        success: function(data) {
                            jQuery("#" + id + "").remove();
                        }
                    });
                    jQuery(this).dialog("close");
                },
                "No": function() {
                    jQuery(this).dialog("close");
                }
            },
            close: function() {
                jQuery(this).dialog("close");
            }
        });
    });
}