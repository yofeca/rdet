<div id="file-upload-box">
    <?php
        $pt = ''; $rb = ''; $rt = '';
        if($research->publication_type == 1) $pt = 'International Publication';
        if($research->publication_type == 2) $pt = 'National Publication';
        if($research->publication_type == 3) $pt = 'Local Publication';
        
        if($research->research_books == 1) $rb = 'Social Researches';
        if($research->research_books == 2) $rb = 'Upland Farm Journal';

        if($research->research_type == 1) $rt = 'Faculty';
        if($research->research_type == 2) $rt = 'Student w/ Faculty';
        if($research->research_type == 3) $rt = 'Community';
        
        if($research->presentation == 1) $p = 'International Fora';
        if($research->presentation == 2) $p = 'National Fora';
        if($research->presentation == 3) $p = 'Local Fora';
    ?>
    <a href="<?php echo base_url('research/preview/' . $research->id); ?>" class="top-go-back">&lt back</a>
    <h4>Research Information:</h4>
    <div id="research-info">
        <strong>Research title:</strong><p><?php echo $research->title; ?></p>
        <strong>Funding agency:</strong><p><?php echo $research->funding_agency; ?></p>
        <div class="col1">
            <strong>Level of Publication:</strong><p><?php echo $pt; ?></p>
            <strong>Research books:</strong><p><?php echo $rb ?></p>
        </div>
        <div class="col2">
            <strong>Research Type:</strong><p><?php echo $rt; ?></p>
            <strong>Level of Presentation:</strong><p><?php echo $p; ?></p>
        </div>
    </div>
    <div id="file-upload-form">
        <form method="post" action="" id="upload_file">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value=""/>
            <input type="submit" name="submit" id="submit" value="Upload" /><br />
            <input type="file" name="userfile" id="userfile" size="20" /><br />
        </form>
    </div>
    <h4>Attachment(s): <i>You can only upload a maximum of five (5) files ( jpg / doc / pdf ).</i></h4>
    <div id="files"></div>    
    <a href="<?php echo base_url('research/preview/' . $research->id); ?>" class="bottom-go-back">&lt back</a>
</div>

