//jQuery(document).ready(function(){
//    n_options = jQuery("select[name=s-n-options]");
//    n_options.hide();
//    
//    jQuery('.ref_pub').on("click",function(){
//        n_options.hide();
//    });
//    
//    jQuery('.ref_au').click(function(){
//        n_options.show();
//    });
//});

////var base_url = location.protocol + "//" + location.hostname + "/rdet/";
//jQuery(document).ready(function(){
//    var options = jQuery("input[name=options]"),
//        type = jQuery("select[name=type]"),
//        status = jQuery("select[name=status]"),
//        filter_nbox = jQuery("#filter_name"),
//        sbox = jQuery("#srch"),
//        filter = jQuery("#filter"),
//        nbox = jQuery("#name_boxes"),
//        btn_submit = jQuery('button[name=submit_filter]'),
//        btn_search = jQuery('button[name=srch_rec]'),
//        empty = jQuery("#err-selection");
//    
//    var lname = jQuery("input[type=checkbox][name=last_name]"),
//        fname = jQuery("input[type=checkbox][name=first_name]"),
//        mname = jQuery("input[type=checkbox][name=middle_name");
//        
//    var l = f = m = false;
//        
//    hide_selections();
//
//    jQuery(options).change(function(){
//        o = jQuery(this).val();
//            jQuery("select[name='status'] option[selected='selected']").each(function(){
//                jQuery(this).removeAttr('selected');
//            });
//            jQuery("select[name='status'] option:first").attr('selected','selected');
//            empty.html("");
//        if(o == "name") {
//            hide_selections();
//            filter_nbox.show();
//            nbox.show();
//            btn_search.show();
//        }else if(o == "title"){
//            hide_selections();
//            status.show();
//            btn_search.show();
//        }else{
//            hide_selections();
//            filter.show();
//            btn_submit.show();
//        }
//    });
//        
//    jQuery(status).change(function(){
//        s = jQuery(this).children(':selected').val();
//        if(s != 0) sbox.show();
//        else sbox.hide();
//    });
//    
//    jQuery(lname).change(function(){
//        (this == true)? l=true:false;
//        alert(l);
//    });
//    
//    jQuery("button[name='srch_rec']").click(function(){
//        s_item = jQuery("input[name='search_item']").val();
//        if(s_item != ''){
//            empty.html("");
//            
//            op = jQuery("input[name=options]:checked").val();
//            
//            if(name.val() == 0){
//                window.location.href = base_url + 'user/advance_search?' + op + '=' + encodeURIComponent(s_item) + "&status=" + status.val();
//            }else{
//                n = name.val();
//                if(n == 'family_name')
//                    window.location.href = base_url + 'user/advance_search?' + n + '=' + encodeURIComponent(s_item);
//                else if(n == 'first_name')
//                    window.location.href = base_url + 'user/advance_search?' + n + '=' + encodeURIComponent(s_item);
//                else
//                    window.location.href = base_url + 'user/advance_search?' + n + '=' + encodeURIComponent(s_item);
//            }
//        }
//        else{
//            jQuery("input[name='search_item']").focus();
//            jQuery("#err-selection").html("test");
//            jQuery("#err-selection").css("background-color","FF0000");
//        }
//            
//    });
//    
//    function hide_selections(){
//        filter.hide();
//        sbox.hide();
//        type.hide();
//        status.hide();
//        filter_nbox.hide();
//        nbox.hide();
//        btn_submit.hide();
//        btn_search.hide();
//        empty.hide();
//    }
//});