var base_url = location.protocol + "//" + location.hostname + "/rdet/";
var author_id = 0, pub_id = 0, st = '', firstrow = 0;
jQuery(document).on("click", "#add-file", function(){    
    jQuery("#file-upload-form").dialog({
        autoOpen: true,
        modal: true,
        width: 415
    });
});

jQuery(document).ready(function(){
    lock_research_fields(true);
    res_id = jQuery("#rid").val();
    
    jQuery("#print-research").click(function(){
        window.location.href = base_url + "research/print_research_preview"
    });
    
    jQuery("#print-research").button({icons:{primary: "ui-icon-print"},text:true});
    
    jQuery("input[name='nr-sc-dcompleted']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "mm/dd/yy",
        constrainInput: true,
        showOn: "both",
        buttonImage: base_url+"media/image/calendar-icon.png"
    });
       
    jQuery("select[name='nr-status']").change( function(){
        sel = jQuery("select[name='nr-status']").val();
        if (sel==1){
            st = 'completed'
            jQuery("#nr-status-completed").css("visibility","visible");
        }else if(sel==2){
            st = 'ongoing'
            jQuery("#nr-status-completed").css("visibility","hidden");
            jQuery("input[name='nr-sc-dcompleted']").val('');
            jQuery("input[name='nr-sc-ypublished']").val('');
        }else
            jQuery("select[name='nr-status'] option[value='0']").attr("selected",true);
    });
    
    jQuery('#logout').button({icons: {primary: "ui-icon-power"}, text: false}).click(function(){ window.location.href = base_url + 'admin/logout'});
    jQuery('#new').button({icons: {primary: "ui-icon-document"}, text: true})
            .click(function(){
                jQuery('#nw-ed-research').dialog({
                    autoOpen: true, 
                    modal: true,
                    width: 520,
                    resizable: false,
                    buttons: {
                        "Save": function(){
                            v = check_nw_ed_research_empty_fields();
                            if(v){
                                var params = {
                                    type: "post",
                                    url: base_url + 'research/async_insert_new_research',
                                    dataType: "json",
                                    data: {
                                        title: jQuery("input[name='nr-title']").val(),
                                        agency: jQuery("input[name='nr-agency']").val(),
                                        ptype: jQuery("select[name='nr-ptype']").val(),
                                        rbooks: jQuery("select[name='nr-rbooks']").val(),
                                        rtype: jQuery("select[name='nr-rtype']").val(),
                                        pres: jQuery("select[name='nr-pres']").val(),
                                        status: jQuery("select[name='nr-status']").val(),
                                        dcomp: jQuery("input[name='nr-sc-dcompleted']").val(),
                                        ypub: jQuery("input[name='nr-sc-ypublished']").val()
                                    },
                                    success: function(response){
                                        if(response.err)
                                            alert(response.msg);
                                        else{
                                            jQuery('#nw-ed-research').dialog("close");
                                            fill_research_fields(response.rid);
                                            populate_research_authors(response.rid);
                                            populate_research_files(response.rid);
                                        }
                                    }
                                };
                                jQuery.ajax(params);
                            }
                        },
                        "Cancel": function(){
                            jQuery('#nw-ed-research').dialog("close");
                        }
                    },close: function(){
                        jQuery(this).dialog("close");
                    },open: function(){
                        clear_nw_ed_research_fields();
                        jQuery("#nr-status-completed").css("visibility","hidden");
                    }
                });
            });
            
    jQuery('#edit').button({icons: {primary: "ui-icon-pencil"}, text: true})
            .click(function(){
                jQuery('#nw-ed-research').dialog({
                    autoOpen: true, 
                    modal: true, 
                    width: 520,
                    resizable: false,
                    buttons: {
                        "Save": function(){
                            v = check_nw_ed_research_empty_fields();
                            if(v){
                                var params = {
                                    type: "post",
                                    url: base_url + 'research/async_update_research',
                                    dataType: "json",
                                    data: {
                                        rid: jQuery("input[name='rid']").val(),
                                        title: jQuery("input[name='nr-title']").val(),
                                        agency: jQuery("input[name='nr-agency']").val(),
                                        ptype: jQuery("select[name='nr-ptype']").val(),
                                        rbooks: jQuery("select[name='nr-rbooks']").val(),
                                        rtype: jQuery("select[name='nr-rtype']").val(),
                                        pres: jQuery("select[name='nr-pres']").val(),
                                        status: jQuery("select[name='nr-status']").val(),
                                        dcomp: jQuery("input[name='nr-sc-dcompleted']").val(),
                                        ypub: jQuery("input[name='nr-sc-ypublished']").val()
                                    },
                                    success: function(response){
                                        if(response.err)
                                            alert(response.msg);
                                        else{
                                            jQuery('#nw-ed-research').dialog("close");
                                            fill_research_fields(response.rid);
                                            populate_research_authors(response.rid);
                                            populate_research_files(response.rid);
                                        }
                                    }
                                };
                                jQuery.ajax(params);
                            }
                        },
                        "Cancel": function(){
                            jQuery(this).dialog("close");
                        }
                    },close: function(){
                        jQuery(this).dialog("close");
                    },open: function(){
                        fill_nw_ed_research_fields();
                    }
                });
            });
            
    jQuery('#delete').button({icons: {primary: "ui-icon-trash"}, text: true})
            .click(function(){
                jQuery('#confirm-delete-research').dialog({
                    autoOpen: true, 
                    modal: true,
                    buttons: {
                        "Yes": function(){
                            var params = {
                                type: "post",
                                url: base_url + 'research/async_delete_research',
                                dataType: "json",
                                data: {
                                    rid: jQuery("input[name='rid']").val()
                                },
                                success: function(response){
                                    if(response.err)
                                        alert(response.msg);
                                    else{
                                        alert(response.msg);
                                        window.location.href = base_url + 'research/preview';
                                    }
                                }
                            };
                            jQuery.ajax(params);
                            jQuery(this).dialog("close");
                        },
                        "Cancel": function(){
                            jQuery(this).dialog("close");
                        }
                    },
                    "close": function(){
                        jQuery(this).dialog("close");
//                        window.location.href = base_url + 'research/preview';
                    }
                });
            });
    
    jQuery('#add-file').button({icons: {primary: "ui-icon-plus"}, text: false});
    jQuery('#submit').button({icons: {primary: "ui-icon-plus"}, text: false});
    //jQuery('#userfile').button({icons: {primary: "ui-icon-plus"}, text: false});
    
    jQuery('#info').dialog({autoOpen: false, modal: true});
    jQuery('#add-research-author').dialog({autoOpen: false, modal: true});
    jQuery('#confirm-remove-author').dialog({autoOpen: false, modal: true});
    jQuery('#confirm-remove-file').dialog({autoOpen: false, modal: true});
    jQuery('#nw-ed-research').dialog({autoOpen: false, modal: true});
    jQuery('#file-upload-form').dialog({autoOpen: false, modal: true});
    jQuery('#confirm-delete-research').dialog({autoOpen: false, modal: true});
    
    jQuery('#add-author')
            .button({icons: {primary: "ui-icon-plus"},text: false})
            .click(function(){
                jQuery('#add-research-author').dialog({
                    autoOpen: true,
                    modal: true,
                    buttons: {
                        "Close": function(){
                            jQuery(this).dialog("close");
                        }
                    },
                    open: function(){
                            jQuery("input[name='research-title']").val('');
                            search_author_autocomplete();
                    },
                    close: function(){
                        jQuery(this).dialog("close");
                    }  
                });
            });
    
    
    jQuery("#jq-researches").jqGrid({ 
        url: base_url + 'research/async_jq_researches',
        datatype: "json", 
        colNames:['#','Title', 'Funding Agency', 'Publication Type','Research Books','Research Type','Presentation','Status','Date Completed','Published'], 
        colModel:[ 
            { name : 'id', index : '', width : 25, fixed : true, align : 'right', sortable : false, resizable : false, search : false },
            { name : 'title', index : '', width : 350, fixed : true, align : 'left', sortable : true, resizable : false, search : true },
            { name : 'funding_agency', index : '', width : 250, fixed : true, align : 'left', sortable : true, resizable : false, search : true },
            { name : 'pubType', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'resBooks', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'resType', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'Pres', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'stat', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'dateComp', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'yearPub', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false }
        ], 
        width: 800,
        height: 150,
        rowNum: 8, 
//        rowList:[10,20,30], 
        pager: '#jq-researches-pages', 
        sortname: 'date_completed', 
        //viewrecords: true, 
        sortorder: "desc", 
        caption:"RDET List of Researches:",
        gridComplete: function() {
            firstrow = $('#jq-researches tr:nth-child(2)').attr('id')
            
            rid = 0;
            
            if(res_id != 0)
                rid = res_id;
            else
                rid = firstrow;
           
            fill_research_fields(rid);
            populate_research_authors(rid);
            populate_research_files(rid);
        },
        onSelectRow : function(rid){
            author_id = rid;
            fill_research_fields(rid);
            populate_research_authors(rid);
            populate_research_files(rid);
        }
    }); 
    
    jQuery("#jq-researches").jqGrid('navGrid','#jq-researches-pages',{edit:false,add:false,del:false,search:false});
    jQuery("#jq-researches").jqGrid('filterToolbar',{searchOperators : true});
    
    jQuery('#upload_file').submit(function(e) {
        e.preventDefault();
        if(jQuery("input[name='filename']").val().length < 1)
            alert('Please enter file name');
        else{
            jQuery.ajaxFileUpload({
            url: base_url + 'upload/async_upload_file',
            secureuri: false,
            fileElementId: 'userfile',
            dataType: 'json',
            data: {
                'title': jQuery("input[name='filename']").val(),
                'rid': jQuery("input[name='rid']").val()
            },
            success: function(data) {
                if(! data.err){
                    alert(data.msg);
                    populate_research_files(jQuery("input[name='rid']").val());
                    jQuery("#file-upload-form").dialog("close");
                }
                else
                    alert(data.msg);
            }
        });
    }
    });
});

function lock_research_fields(v) {
    jQuery('.ri-fields').attr("disabled", v);
}

function fill_research_fields(id) {
    var params = {
        type: 'post',
        url: base_url + 'research/async_research_data',
        dataType: 'json',
        data: {
            rid: id
        },
        success: function(response){
            jQuery("input[name='rid']").val(response.rid);
            jQuery("input[name='title']").val(response.title);
            jQuery("input[name='agency']").val(response.agency);
            jQuery("input[name='ptype']").val(response.pt);
            jQuery("input[name='rbooks']").val(response.rb);
            jQuery("input[name='rtype']").val(response.rt);
            jQuery("input[name='pres']").val(response.p);
            jQuery("input[name='stat']").val(response.s);
            jQuery("input[name='dcompleted']").val(response.dc);
            jQuery("input[name='ypublished']").val(response.yp);
            jQuery("input[name='dloads']").val(response.dloads);
            jQuery("input[name='views']").val(response.views);
        }
    }
    jQuery.ajax(params);
}

function clear_research_fields() {
    jQuery('.ri-fields').val('');
}

function populate_research_authors(rid){
    jQuery('#author').html('');
    jQuery.post(base_url + 'research/async_research_authors',{ rid: rid },
        function(data){
            if(jQuery.isEmptyObject(data)){               
                jQuery("#author").append('<li style="list-style: none">This title has no author.</li>');
            }else{
                jQuery.each(data, function( k, v ){
                    name = "<strong><a href='" + base_url +'author/preview/'+ v.id + "'>" + v.last_name + ", " + v.first_name + " " + v.middle_name + "</a></strong>";
                    remove_author = "<a id='remove-" + v.id + "' class='remove-author'>remove</a>";
                    list = "<li id='" + v.id + "'>" + name + remove_author + "</li>";
                    jQuery("#author").append(list);
                
                        jQuery("#remove-" + v.id + "").click(function() {
                            
                        jQuery('#confirm-remove-author').dialog({
                            autoOpen: true,
                            modal: true,
                            buttons: {
                                "Yes": function() {
                                    $.ajax({
                                        type: 'post',
                                        url: base_url + 'research/async_remove_research_authors',
                                        data: {
                                            auid: v.id,
                                            rid: rid
                                        },
                                        dataType: 'json',
                                        success: function(data) {
                                            jQuery("#" + v.id + "").remove();
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
                });
            }
         }, "json");
}

function search_author_autocomplete(){
        jQuery("input[name='research-author']").autocomplete({
        source: function(request, response){
            $.ajax({
                    type: 'post',
                    url: base_url + 'research/async_research_author_autocomplete',
                    dataType: 'json',
                    data:{
                        lastname: request.term,
                    },
                    success: function(data){
                        if(! data.error)
                           response($.map(data, function(item){                                   
                                return {
                                    id: item.id,
                                    label: item.last_name + ', ' + item.first_name + ' ' + item.last_name
                                }
                           }));
                    }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            jQuery.ajax({
                type: 'post',
                url: base_url + 'research/async_insert_research_author',
                dataType: 'json',
                data: {
                    aid: ui.item.id, 
                    rid: jQuery("input[name='rid']").val()
                },
                success: function(response){
                    if(response.err)
                        display_info_dialog(response.msg)
                    else
                        populate_research_authors(jQuery("input[name='rid']").val());
                        jQuery("input[name='research-author']").val('');
                }
            });
        }
    });
}

function display_info_dialog(info) {
    jQuery('#info').dialog({
        autoOpen: true,
        modal: true,
        buttons: {
            "Ok": function() {
                jQuery(this).dialog("close");
            }
        },
        open: function() {
            jQuery("#info p").html(info);
        },
        close: function() {
            jQuery(this).dialog("close");
        }
    });
}

function populate_research_files(rid){
    jQuery('#files').html('');
    jQuery.post(base_url + 'upload/async_research_files',{ rid: rid },
        function(data){
            if(jQuery.isEmptyObject(data)){               
                jQuery("#files").append('<li style="list-style: none">This title has no files attached.</li>');
            }else{
                jQuery.each(data, function( k, v ){
                    filename = "<strong><a target='_blank' href='" + base_url +'files/'+ v.filename + "'>" + v.title + "</a></strong>";
                    removefile ="<a href='#' class='remove-file-link' id='remove-" + v.id + "'>Delete</a>";
                    //editfile ="<a href='#' class='edit-file-link' id='edit-" + v.id + "'>Edit</a>";
                    
                    list = "<li id='f-" + v.id + "'>" + filename + removefile + "</li>";
                    jQuery("#files").append(list);
                
//                    jQuery("#edit-" + v.id).click(function(){ alert('edit')});
                    jQuery("#remove-" + v.id).click(function() {
                    jQuery('#confirm-remove-file').dialog({
                        autoOpen: true,
                        modal: true,
                        buttons: {
                            "Yes": function() {
                                $.ajax({
                                    type: 'post',
                                    url: base_url + 'upload/async_delete_research_file',
                                    data: {
                                        fid: v.id
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        if(data.err)
                                            alert('delete error');
                                        else
                                            jQuery("#f-" + v.id + "").remove();
                                        
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
                });
            }
         }, "json");
 }

function clear_nw_ed_research_fields(){
    jQuery("input[name='nr-title']").val('');
    jQuery("input[name='nr-agency']").val('');
    jQuery("select option[value='0']").attr("selected",true);
    jQuery("input[name='nr-sc-dcompleted']").val('');
    jQuery("input[name='nr-sc-ypublished']").val('');
}

function fill_nw_ed_research_fields(){       
    var title = jQuery("input[name='title']").val(),
        agency = jQuery("input[name='agency']").val(),
        ptype = jQuery("input[name='ptype']").val(),
        rbooks = jQuery("input[name='rbooks']").val(),
        rtype = jQuery("input[name='rtype']").val(),
        pres = jQuery("input[name='pres']").val(),
        stat = jQuery("input[name='stat']").val(),
        dcomp = jQuery("input[name='dcompleted']").val(),
        ypub = jQuery("input[name='ypublished']").val(),
        dloads = jQuery("input[name='dloads']").val(),
        views = jQuery("input[name='views']").val();
    
    jQuery("input[name='nr-title']").val(title);
    jQuery("input[name='nr-agency']").val(agency);
    
    if (ptype.toUpperCase() == 'INTERNATIONAL')
        jQuery("select[name='nr-ptype'] option[value='1']").attr("selected",true);
    else if(ptype.toUpperCase() == 'NATIONAL')
        jQuery("select[name='nr-ptype'] option[value='2']").attr("selected",true);
    else if(ptype.toUpperCase() == 'LOCAL')
        jQuery("select[name='nr-ptype'] option[value='3']").attr("selected",true);
    else
        jQuery("select[name='nr-ptype'] option[value='0']").attr("selected",true);
    
    if (rbooks.toUpperCase() == 'SOCIAL RESEARCHES')
        jQuery("select[name='nr-rbooks'] option[value='1']").attr("selected",true);
    else if(rbooks.toUpperCase() == 'UPLAND FARM JOURNAL')
        jQuery("select[name='nr-rbooks'] option[value='2']").attr("selected",true);
    else
        jQuery("select[name='nr-rbooks'] option[value='0']").attr("selected",true);

    if (rtype.toUpperCase() == 'FACULTY')
        jQuery("select[name='nr-rtype'] option[value='1']").attr("selected",true);
    else if(rtype.toUpperCase() == 'STUDENTS W/ FACULTY')
        jQuery("select[name='nr-rtype'] option[value='2']").attr("selected",true);
    else if(rtype.toUpperCase() == 'COMMUNITY')
        jQuery("select[name='nr-rtype'] option[value='3']").attr("selected",true);
    else
        jQuery("select[name='nr-rtype'] option[value='0']").attr("selected",true);
    
    if (pres.toUpperCase() == 'INTERNATIONAL FORA')
        jQuery("select[name='nr-pres'] option[value='1']").attr("selected",true);
    else if(pres.toUpperCase() == 'NATIONAL FORA')
        jQuery("select[name='nr-pres'] option[value='2']").attr("selected",true);
    else if(pres.toUpperCase() == 'LOCAL FORA')
        jQuery("select[name='nr-pres'] option[value='3']").attr("selected",true);
    else
        jQuery("select[name='nr-pres'] option[value='0']").attr("selected",true);
    
    if (stat.toUpperCase() == 'COMPLETED'){
        jQuery("select[name='nr-status'] option[value='1']").attr("selected",true);
        jQuery("#nr-status-completed").css("visibility","visible");
        jQuery("input[name='nr-sc-dcompleted']").val(dcomp);
        jQuery("input[name='nr-sc-ypublished']").val(ypub);
    }else if(stat.toUpperCase() == 'ONGOING'){
        jQuery("select[name='nr-status'] option[value='2']").attr("selected",true);
        jQuery("#nr-status-completed").css("visibility","hidden");
        jQuery("input[name='nr-sc-dcompleted']").val('');
        jQuery("input[name='nr-sc-ypublished']").val('');
    }else
        jQuery("select[name='nr-status'] option[value='0']").attr("selected",true);
    
    
}

function check_nw_ed_research_empty_fields(){
    if(jQuery("input[name='nr-title']").val().length <3){
        alert('Invalid research title');
        jQuery("input[name='nr-title']").focus();
        
    } else if (jQuery("input[name='nr-agency']").val().length <3){
        alert('Invalid funding agency name');
        jQuery("input[name='nr-agency']").focus();
        
    } else if (jQuery("select[name='nr-ptype']").val() == '0'){
        alert('Please select publication type.');
        jQuery("select option[name='nr-ptype']").focus();
        
    } else if (jQuery("select[name='nr-rbooks']").val() == '0'){
        alert('Please select research books.');
        jQuery("select option[name='nr-rbooks']").focus();
        
    } else if (jQuery("select[name='nr-rtype']").val() == '0'){
        alert('Please select research type.');
        jQuery("select option[name='nr-rtype']").focus();
        
    } else if (jQuery("select[name='nr-pres']").val() == '0'){
        alert('Please select presentation.');
        jQuery("select option[name='nr-pres']").focus();
        
    } else if (jQuery("select[name='nr-status']").val() == '0'){
        alert('Please select status.');
        jQuery("select option[name='nr-status']").focus();
    }else{
        if(st == 'completed'){
            if(jQuery("input[name='nr-sc-dcompleted']").val().length < 3){
                alert('Invalid date completed.');
                jQuery("input[name='nr-sc-dcompleted']").focus();
            }else if(jQuery("input[name='nr-sc-ypublished']").val().length < 3){
                alert('Invalid year published.');
                jQuery("input[name='nr-sc-ypublished']").focus();
            }else if (! (jQuery.isNumeric(jQuery("input[name='nr-sc-ypublished']").val()))){
                alert("Invalid year published.");
                jQuery("input[name='nr-sc-ypublished']").focus();
            }else{
                st = '';
                return true;
            }
        }else{
            st = '';
            return true;
        }
    }
    return false;
}