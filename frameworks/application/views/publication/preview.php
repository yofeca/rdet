<div id="research-info">
    <h4>Research Information<button id="print-research" style="font-size: 10px; margin: 0; float: right;">Print</button></h4>
    <input type="hidden" name="rid" id="rid" value="<?php echo $rid; ?>" />
    <input type="hidden" name="pubid" />
    
    <div id="col1">
        <div>
            <label for="title">Title of Research:</label>
            <input type="text" name="title" class="ri-fields"/>
        </div>
        <div>
            <label for="agencey">Funding Agency:</label>
            <input type="text" name="agency" class="ri-fields"/>
        </div>
        <div>
            <label for="ptype">Publication Type:</label>
            <input type="text" name="ptype" class="ri-fields"/>
        </div>
        <div>
            <label for="rbooks">Research Books:</label>
            <input type="text" name="rbooks" class="ri-fields"/>
        </div>
        <div>
            <label for="rtype">Research Type:</label>
            <input type="text" name="rtype" class="ri-fields"/>
        </div>
        <div>
            <label for="pres">Presentation:</label>
            <input type="text" name="pres" class="ri-fields"/>
        </div>
    </div>
    
    <div id="col2">
        <div>
            <label for="stat">Status:</label>
            <input type="text" name="stat" class="ri-fields"/>
        </div>
        <div>
            <label for="dcompleted">Date Completed:</label>
            <input type="text" name="dcompleted" class="ri-fields"/>
        </div>
        <div>
            <label for="ypublished">Year Published:</label>
            <input type="text" name="ypublished"class="ri-fields" />
        </div>
        <div>
            <label for="dloads">Downloads:</label>
            <input type="text" name="dloads" class="ri-fields"/>
        </div>
        <div>
            <label for="views">Views:</label>
            <input type="text" name="views" class="ri-fields"/>
        </div>
        
        <div id="buttons">
            <button id="new">New</button>
            <button id="edit">Edit</button>
            <button id="delete">Delete</button>
        </div>
    </div>
</div>
<div id="au-attachment">
    <div id="au-at-col1">
        <h4>Authors: <button id="add-author">Add author</button></h4>
        <div>
        <ol id="author"></ol>
        </div>
    </div>
    <div id="au-at-col2">
        <h4>Attachments: <button id="add-file">Add File</button></h4>
        <div>
        <ol id="files"></ol>
        </div>
    </div>
</div>
<div id="research-table">
    <table id="jq-researches"></table>
    <div id="jq-researches-pages"></div>
</div>

<div id="confirm-remove-author" title="Remove Author">
    <p>Are you sure you want to remove this author?</p>
</div>

<div id="add-research-author" title="Add Author">
    <label for="research-author">Type Authors Family name:</label>
    <input type="text" name="research-author" style="width: 270px" />
</div>

<div id="info">
    <p></p>
</div>

<div id="file-upload-form" title="Add File">
    <form method="post" action="" id="upload_file">
        <label for="filename">File Name:</label>
        <input type="text" name="filename" class="text ui-corner-all ui-widget-content" value=""/>
        <input type="file" name="userfile" id="userfile" size="20" /><br />
        <input type="submit" name="submit" id="submit" value="Upload" /><br />
    </form>
</div>

<div id="confirm-remove-file" title="Remove File">
    <p>Are you sure you want to remove this file?</p>
</div>

<div id="nw-ed-research" title="Add/Edit Research">
    <p id="validateTips">All form fields are required</p>
    <label for="nr-title">Research title:</label>
    <input type="text" name="nr-title" />
    
    <label for="nr-agency">Funding agency:</label>
    <input type="text" name="nr-agency" />
    
    <div id="nr-ptype">
        <label for="nr-ptype">Publication type:</label>
        <select name="nr-ptype">
            <option value="0">--</option>
            <option value="1">International</option>
            <option value="2">National</option>
            <option value="3">Local</option>
        </select>
    </div>
    
    <div id="nr-rbooks">
        <label for="nr-rbooks">Research books:</label>
        <select name="nr-rbooks">
            <option value="0">--</option>
            <option value="1">Social Researches</option>
            <option value="2">Upland Farm Journal</option>
        </select>
    </div>
    
    <div id="nr-rtype">
        <label for="nr-rtype">Research type:</label>
        <select name="nr-rtype">
            <option value="0">--</option>
            <option value="1">Faculty</option>
            <option value="2">Students w/ faculty</option>
            <option value="3">Community</option>
        </select>
    </div>
    
    <div id="nr-pres">
        <label for="nr-pres">Presentation:</label>
        <select name="nr-pres">
            <option value="0">--</option>
            <option value="1">International Fora</option>
            <option value="2">National Fora</option>
            <option value="3">Local Fora</option>
        </select>
    </div>
    
    <div id="nr-status">
        <label for="nr-status">Status:</label>
        <select name="nr-status">
            <option value="0">--</option>
            <option value="1">Completed</option>
            <option value="2">Ongoing</option>
        </select>
    </div>
    
    <div id="nr-status-completed">
        <label for="nr-sc-dcompleted">Date Completed:</label>
        <input type="text" name="nr-sc-dcompleted" disabled/>
        <label for="nr-sc-ypublished">Year Published:</label>
        <input type="text" name="nr-sc-ypublished" />
    </div>
</div>

<div id="confirm-delete-research" title="Delte Research">
    <p>Are you sure you want to delete this Research?</p>
</div>