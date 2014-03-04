var display_id = 0;

jQuery(document).ready(function(){

function populate_field_data(){
        jQuery.post(base_url + 'author/async_preview_author', { auid: display_id },
            function(response) {                         
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

function populate_author_published_books(){
    jQuery('#list-pub-books').html('');
    jQuery.post(base_url + 'author/async_author_published_books',{ auid: jQuery('#auid').val() },
        function(data){
            console.log(data);
              jQuery.each( data, function(k, v){
                        list = '<li>' + v.title + '</li>';
                        jQuery('#list-pub-books').append(list);
              });
         }, "json");
         
         
}
});


