<h4 id="h-user-info">User Information</h4>
<h4 id="h-acc-info">Account Information</h4>
<div id="user-profile-info">
    <div>
        <label for="employee_id">Employee ID:</label>
        <input type="hidden" name="pid" id="pid" value="<?php echo $profile->pid ?>"/>
        <input class="text ui-corner-all ui-widget-content" type="text" name="employee_id" id="employee_id" value="<?php echo $profile->emp_id; ?>"/>
    </div>
    <div>
        <label for="first_name">First Name:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="first_name" id="first_name" value="<?php echo $profile->first_name; ?>"/>
    </div>
    <div>
        <label for="middle_name">Middle Name:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="middle_name" id="middle_name" value="<?php echo $profile->middle_name; ?>"/>
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="last_name" id="last_name" value="<?php echo $profile->last_name; ?>"/>
    </div>
    <div>
        
        <?php 
        
            if($profile->birth_date == '0000-00-00' || $profile->birth_date == NULL)
                $d = "";
            else{
                $d = getdate(strtotime($profile->birth_date));
                $d = $d['month'] . " " . $d['mday'] . ", " . $d['year'];
            }
        ?>
        <label for="birth_date">Birth Date:</label>
        <input class="text ui-corner-all ui-widget-content"  type="date" name="birth_date" id="birth_date" value="<?php echo $d; ?>"/>
    </div>
    <div>
        <label for="sex">Sex:</label>
        <select name="sex" id="sex">
            <option value="" <?php if($profile->sex == '') echo 'selected="selected"'?>></option>
            <option value="MALE" <?php if($profile->sex == 'MALE') echo 'selected="selected"'?>>Male</option>
            <option value="FEMALE" <?php if($profile->sex == 'FEMALE') echo 'selected="selected"'?>>Female</option>
        </select>
    </div>   
    <div>
        <label for="address">Address:</label>
        <textarea  class="ui-corner-all ui-widget-content" name="address" id="address"><?php if($profile->address) echo $profile->address; ?></textarea>
    </div>
    <div id="user-profile-buttons">
        <button id="edit">Edit</button>
        <button id="save">Save</button>
        <button id="cancel">Cancel</button>
    </div>
</div>

<div id="profile-user-acc">
    <div>
        <label for="username" class="profile-label">Username:</label>
        <input type="hidden" name="uid" id="uid" value="<?php echo $profile->uid ?>"/>
        <input class="text ui-corner-all ui-widget-content"  type="text" name="username" id="username" value="<?php echo $profile->username; ?>" />
    </div>   
    <div>
        <label for="password" class="profile-label">Password:</label>
        <input class="text ui-corner-all ui-widget-content"  type="password" name="password" id="password" value="<?php echo "qwerty";/*$profile->password;*/ ?>" />
    </div>
    <button id="edit-account">Edit</button>
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


