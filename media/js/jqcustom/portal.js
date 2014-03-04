var base_url = location.protocol + "//" + location.hostname + "/rdet/";
$(document).ready(function() {

    jQuery('#logout').button({icons: {primary: "ui-icon-power"}, text: false}).click(function(){ window.location.href = base_url + 'admin/logout'});
    
        jQuery("#home-records").jqGrid({ 
        url: base_url + 'research/async_jq_home_researches',
        datatype: "json", 
        colNames:['#','Title', 'Funding Agency', 'Publication Type','Research Books','Research Type','Presentation','Status','Date Completed','Published'], 
        colModel:[ 
            { name : 'id', index : '', width : 25, fixed : true, align : 'right', sortable : false, resizable : false, search : false },
            { name : 'title', index : 'title', width : 350, fixed : true, align : 'left', sortable : true, resizable : false, search : true },
            { name : 'funding_agency', index : '', width : 250, fixed : true, align : 'left', sortable : true, resizable : false, search : true },
            { name : 'publication_type', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'research_books', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'research_type', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'presentation', index : '', width : 150, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'status', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'date_completed', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false },
            { name : 'year_published', index : '', width : 100, fixed : true, align : 'center', sortable : true, resizable : false, search : false }
        ], 
        width: 800,
        height: 580,
        rowNum: 50, 
        //rowList:[50,100,30], 
        pager: '#hr-pager', 
        sortname: 'date_completed', 
        sortorder: "desc", 
        caption:"RDET List of Researches:",
        gridComplete: function() {
            firstrow = $('#jq-researches tr:nth-child(2)').attr('id')
        },
        onSelectRow : function(rid){
            window.location.href = base_url + 'research/preview/' + rid;
        }
    });

    jQuery("#home-records").jqGrid('navGrid','#hr-pager',{edit:false,add:false,del:false,search:false});
    jQuery("#home-records").jqGrid('filterToolbar',{searchOperators : true});

    jQuery(".ui-jqgrid-titlebar a").hide();

//    $("#bsdata")
//    .button()
//    .click(function(){ 
//        jQuery("#home-records").jqGrid('searchGrid', {
//            sopt:['cn','bw','eq']
//        }); 
//
//    });
/*    jQuery('#gen-search button').button({icons: {primary: "ui-icon-search"},text: false})
            .click(function(){

                var cat_url = '', view = '', col1 ='', col2='', col3='', col4='';
        
                if(jQuery("select[name='gs-category']").val() == 1){
                    cat_url = 'research/async_general_search_title';
                    view = 'research/preview/';
                    col1 = 'Title', col2='Status', col3='Completed', col4='Published';
                }else if(jQuery("select[name='gs-category']").val() == 2){
                    cat_url = 'author/async_general_search_author';
                    view = 'author/preview/';
                    col1 = 'Name', col2='', col3='', col4='Type';
                }else if(jQuery("select[name='gs-category']").val() == 3){
                    cat_url = 'admin/async_general_search_account';
                    view = 'admin/manage_accounts/';
                    col1 = 'Name', col2='Employee ID', col3='User Type', col4='Username';
                }else{
                    cat_url = '';
                    col1 = '', col2='', col3='', col4='';
                }
                
                if(! jQuery("input[name='gs-item']").val() == ''){
                    var params = {
                        type: "post",
                        url: base_url + cat_url,
                        dataType: "json",
                        data:{
                            item: jQuery("input[name='gs-item']").val()
                        },
                        success: function(response){
                            jQuery("#gsr-result").html('');
                            if(! jQuery.isEmptyObject(response)){
                                tr = "<tr> <th width='400px'>" + col1 +"</th> <th width='130px'>" + col2 +"</th> <th width='130px'>" + col3 +"</th> <th width='180px'>" + col4 +"</th> </tr>"
                                jQuery("#gsr-result").append(tr);

                                jQuery.each(response, function(k, v){
                                    link = "<a href='" + base_url + view + v.response['0']+"'>";
                                    col1 = "<td>" + link + v.response['1']+ "</a></td>";
                                    col2 = "<td>" + v.response['2']+ "</td>";
                                    col3 = "<td>" + v.response['3']+ "</td>";
                                    col4 = "<td>" + v.response['4']+ "</td>";
                                    tr = "<tr>" + col1 + col2 + col3 + col4 + "</tr>"
                                    jQuery("#gsr-result").append(tr);
                                });
                            }
                        }
                    };
                jQuery.ajax(params);
            }
            });*/
});