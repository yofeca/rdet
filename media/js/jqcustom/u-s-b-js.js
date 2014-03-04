var base_url = location.protocol + "//" + location.hostname + "/rdet/";
var s = 1;
$(document).ready(function(){
    $('#main-search-button').button({icons: {primary: "ui-icon-search"}, text: false});
    $('#logout').button({icons: {primary: "ui-icon-power"}, text: true})
    .click(function(){ window.location.href = base_url + 'admin/logout'});
    $('#user').button({icons: {primary: "ui-icon-person"}, text: false})
              .click(function(){
                  window.location.href = base_url + 'admin/myprofile'});

    $('#user-search-box select').change(function(){
        s = $('#user-search-box select').val();
    });
    
    $('#search-box').autocomplete({
        source: function(request, response){
            $.ajax({
                    url: base_url + 'research/find',
                    dataType: 'json',
                    data:{
                        name_startsWith: request.term,
                        searchType: s
                    },
                    success: function(data){
                        if(!data.error)
                           response($.map(data, function(item){                                   
                               if(s == 1 ){
                               return {
                                   label: item.title,
                                   id: item.id
                               }
                           }
                           if(s == 2){
                            return {
                                   label: item.last_name + ", " + item.first_name,
                                   id: item.id,
                               }
                           }
                           }));
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                if(s == 1) window.location.href = base_url + 'user/preview_research/'+ui.item.id
                    
                if(s == 2) window.location.href = base_url + 'user/preview_author/'+ui.item.id
            },
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
    });
});