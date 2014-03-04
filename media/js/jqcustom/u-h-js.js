jQuery(document).ready(function(){
    var base_url = location.protocol + "//" + location.hostname + "/rdet/";
    $('#display-options').buttonset();
    
    view_pub_list();

    $('#filter-by-status input').change(function(){ view_pub_list(); });
    $('#filter-by-presentation input').change(function(){ view_pub_list(); });
    
    function view_pub_list(){
        
        var filter_by_status = jQuery('#filter-by-status input[type=radio]:checked').val();
        var filter_by_presentation = jQuery('#filter-by-presentation input[type=radio]:checked').val();
                
        var params = { 
            type: 'POST',
            url: base_url+'user/list_publications',
            data: {
                filter_by_status: filter_by_status,
                filter_by_presentation: filter_by_presentation
            },
            success : function(response) {
                
                jQuery('#list-of-titles').html(response);
                 //jQuery('#list-of-titles').text('sdfsdf');
            }
        };
        
        jQuery.ajax(params);
    }
});