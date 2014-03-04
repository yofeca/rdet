var base_url = location.protocol + "//" + location.hostname + "/rdet/";

jQuery(document).ready(function() {  
    $("td a[href $='.pdf']").before('<img class="file-icons" src='+ '"' + base_url + 'media/image/icon/pdf.ico" align="absbottom" />');
    $("td a[href $='.jpeg']").before('<img class="file-icons" src='+ '"' + base_url + 'media/image/icon/image.ico" align="absbottom" />');
    $("td a[href $='.jpg']").before('<img class="file-icons" src='+ '"' + base_url + 'media/image/icon/image.ico" align="absbottom" />');
    $("td a[href $='.doc']").before('<img class="file-icons" src='+ '"' + base_url + 'media/image/icon/word.ico" align="absbottom" />');
    $("td a[href $='.docx']").before('<img class="file-icons" src='+ '"' + base_url + 'media/image/icon/word.ico" align="absbottom" />');
});