<div id="user-search-box">
    <input type="text" name="txt-search" id="search-box" />
    <strong>Search:</strong>
    <select name="search-pub" id="search-type">
        <option value="0" id="0">Last Name</option>
        <option value="1" id="1">First Name</option>
    </select>
</div>

<h4>Personal Information:</h4>
<div id="author">
    <input type="hidden" name="au_sid" value="<?php //echo $auid; ?>"/>
    <input type="hidden" name="author_id" id="auid" value=""/>
    <input type="hidden" name="person_id" id="pid" value=""/>
    <div id="author-name">
        <label  for="first_name" class="label">First name:</label>
        <input class="text ui-widget-content ui-corner-all" type="text" name="first_name" id="first_name" value="" disabled/>

        <label for="middle_name" class="label">Middle name:</label>
        <input class="text ui-widget-content ui-corner-all" type="text" name="middle_name" id="middle_name" value="" disabled/>

        <label for="last_name" class="label">Last name:</label>
        <input class="text ui-widget-content ui-corner-all" type="text" name="last_name" id="last_name" value="" disabled/>
    </div>
    
    <div id="other-info">
        <label for="sex" class="label">Sex:</label>
        <input type="text" name="sex" id="sex" class="text ui-widget-content ui-corner-all" value="" disabled/>
        <label for="type" class="label">Type:</label>
        <input type="text" name="type" id="type" class="text ui-widget-content ui-corner-all" value="" disabled/>
    </div>
    
    <div id="author-buttons">
        <button id="new">New</button>
        <button id="edit">Edit</button>
        <button id="delete">Delete</button>
    </div>
    
</div>

<h4>Published researches: <button id="add-title"style="text-decoration: underline; float: right; margin-right: 5px; margin-top: -2px; font-size: 10px; ">Add research title</button></h4>
<div id="published-books">
    <ol id="list-pub-books"> </ol>
</div>

<!--jQuery Grid-------------------------------------------------->
<div id="jq-grid-author">
    <table id="author-list"></table>
    <div id="author-list-pager"></div>
</div>

<!--Dialog Boxes------------------------------------------------->
    <div id="author-dialog-form" title="New Author">
        
        <p id="validateTips">All form fields are required</p>
        
        <label  for="first_name" class="adf-labels">First name:</label>
        <input class="text ui-widget-content ui-corner-all" type="text" name="first_name" id="adf-first-name" value=""/>

        <label for="middle_name" class="adf-labels">Middle name:</label>
        <input class="text ui-widget-content ui-corner-all" type="text" name="middle_name" id="adf-middle-name" value=""/>

        <label for="last_name" class="adf-labels">Last name:</label>
        <input class="text ui-widget-content ui-corner-all" type="text" name="last_name" id="adf-last-name" value=""/>
    
        <label for="adf-btn-sex" id="sex-label" class="adf-labels">Sex:</label>
        <div id="adf-btn-sex">
            <input type="radio" name="adf_sex" value="MALE"/><p>Male</p>
            <input type="radio" name="adf_sex" value="FEMALE"/><p>Female</p>
        </div>
        
        <div id="adf-type">
            <p id="sel-type-label" class="adf-labels">Author Type:</p>
            <select name="adf-sel-type" id="adf-sel-type">
                <option value="0">--</option>
                <option value="1">Faculty</option>
                <option value="2">Student</option>
                <option value="3">Community</option>
            </select>
        </div>
    </div>

<div id="success" title="Sucess">
    <p></p>
</div>

<div id="confirmation" title="Confirmation">
    <p></p>
</div>

<div id="confirm-remove-book" title="Remove title?">
    <p>Are you sure you want to remove this title from the author?</p>
</div>

<div id="confirm-delete-author" title="Delete author?">
    <p>Are you sure you want to this author?</p>
</div>

<div id="add-research-title" title="Add Research Title">
    <label for="research-title">Type the research title:</label>
    <input type="text" name="research-title" style="width: 270px" />
</div>
