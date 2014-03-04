<h4 id="h-user-info">User Information</h4>
<h4 id="h-acc-info">Account Information</h4>
<div id="user-profile-info">
    <div>
        <label for="employee_id">Employee ID:</label>
        <input type="hidden" name="pid" id="pid" value=""/>
        <input class="text ui-corner-all ui-widget-content" type="text" name="employee_id" id="employee_id" />
    </div>
    <div>
        <label for="first_name">First Name:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="first_name" id="first_name" />
    </div>
    <div>
        <label for="middle_name">Middle Name:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="middle_name" id="middle_name" />
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="last_name" id="last_name" />
    </div>
    <div>
        <label for="birth_date">Birth Date:</label>
        <input class="text ui-corner-all ui-widget-content"  type="date" name="birth_date" id="birth_date" />
    </div>
    <div>
        <label for="sex" style="float: left;">Sex:</label>
        <div id="sex" style="width: 295px; float: left; margin-left: 5px;"  class="text ui-corner-all ui-widget-content">
        <input type="radio" name="sex" value="MALE" style="margin-left: 5px; margin-right: 5px; margin-top: 5px;" />Male
        <input type="radio" name="sex" value="FEMALE" style="margin-left: 10px; margin-right: 5px; margin-top: 5px;" />Female
        </div>
    </div>
    <div style="clear: left;">
    <table>
        <tr>
            <td style="vertical-align: top;"><label for="address">Address:</label></td>
            <td><textarea  class="ui-corner-all ui-widget-content" name="address" id="address"></textarea></td>
        </tr>
    </table>
    </div>
</div>

<div id="profile-user-acc">
    <div>
        <label for="username" class="profile-label">Username:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="username" id="username" />
    </div>   
    <div>
        <label for="password1" class="profile-label">Password:</label>
        <input class="text ui-corner-all ui-widget-content"  type="password" name="password1" id="password1" />
        <p id="update-user-account"><strong>Edit Account</strong></p>
    </div>
    <div id="display-password2">
        <label for="password2" class="profile-label">Retype password:</label>
        <input class="text ui-corner-all ui-widget-content"  type="password" name="password2" id="password2" />
        
    </div>
    <div>
        <label style="float: left;">User type:</label>
        <div id="usertype" style="width: 185px; float: left; margin-left: 5px;"  class="text ui-corner-all ui-widget-content">
            <input type="radio" name="usertype" id="usertype" value="1" style="margin-left: 5px; margin-right: 5px; margin-top: 5px;"/>Administrator
            <input type="radio" name="usertype" id="usertype" value="2" style="margin-left: 10px; margin-right: 5px;"/>User
            </di>
        </div>
        <div style="width: 320px; float: left; margin-top: 5px; background: #FBE6F2;" class="text ui-corner-all ui-widget-content">
            <input type="checkbox" name="active" id="active" value="1" style="margin-top: 5px; margin-right: 5px;"/>Check this box to make the user <strong>activate</strong>.
        </div>
        <div id="err-fields" style=" height: 2em; width: 320px; margin-top: 20px; margin-left: 5px; float: left;"></div>
        
        <div id="m-account-buttons">
            <button id="new">New</button>
            <button id="edit">Edit</button>
            <button id="save">Save</button>
            <button id="cancel">Cancel</button>
            <button id="delete">Delete</button>
        </div>
    </div>
</div>
<div style="float: left; margin-left: 10px; margin-top: 10px;">
    <table id="list"></table>
    <div id="list_pager"></div>   
</div>

<div id="edit-account-dialog" title="Edit Account">
    <p class="validate-error"></p>
    <label for="e-a-username">Username:</label>
    <input type="text" name="e-a-username" id="e-a-username" class="text ui-corner-all ui-widget-content"/>
    
    <label for="e-a-password1">Password:</label>
    <input type="password" name="e-a-password1" id="e-a-password1" class="text ui-corner-all ui-widget-content"/>
    
    <label for="e-a-password2">Retype password:</label>
    <input type="password" name="e-a-password2" id="e-a-password2" class="text ui-corner-all ui-widget-content"/>
</div>

<div id="dialog-confirm-delete" title="Delete account?">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>The account will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

