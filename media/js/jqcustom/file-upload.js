var base_url = location.protocol + "//" + location.hostname + "/rdet/";
$(document).ready(function() {
    refresh_files();

    $('#upload_file').submit(function(e) {
        e.preventDefault();

        $.ajaxFileUpload({
            url: './upload/upload_file',
            secureuri: false,
            fileElementId: 'userfile',
            dataType: 'json',
            data: {
                'title': $('#title').val(),
                'res_id': $('res_id').val()
            },
            success: function(data) {
                if (data.status === "success") {
                    $('#files').html('<p>Reloading files...</p>');
                    $('#title').val('');
                    refresh_files();
                    alert(data.msg);
                }else{
                    alert(data.msg);
                }
            }
        });
        return false;
    });

    $(document).on('click', '.delete_file_link', function(e){ //    $('.delete_file_link').live('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this file?')) {
            var link = $(this);
            $.ajax({
                url: './upload/delete_file/' + link.data('file_id'),
                dataType: 'json',
                success: function(data) {
                    files = $('#files');
                    if (data.status === "success") {
                        refresh_files();
                        link.parents('li').fadeOut('fast', function() {
                            $(this).remove();
                            if (files.find('li').length == 0) {
                                files.html('<p>No Files Uploaded</p>');
                            }
                        });
                    } else {
                        alert(data.msg);
                    }
                }
            });
        }
    });
});

function refresh_files() {
    $.get('./upload/files/')
            .success(function(data) {
        $('#files').html(data);
    });
}