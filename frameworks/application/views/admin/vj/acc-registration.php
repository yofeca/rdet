<?php
extract($_POST);
$response = array();
$response['error'] = 0;

if (!validate_name($emp_id)) {
    $response['error'] = 1;
    $response['field'] = 'employee_id';
    $response['message'] = 'Please enter your Employee ID.';
} else if (!validate_name($fname)) {
    $response['error'] = 1;
    $response['field'] = 'first_name';
    $response['message'] = 'Please enter your Firts Name.';
//} else if (!validate_name($mname)) {
//    $response['error'] = 1;
//    $response['field'] = 'middle_name';
//    $response['message'] = 'Please enter your Middle Name.';
} else if (!validate_name($lname)) {
    $response['error'] = 1;
    $response['field'] = 'last_name';
    $response['message'] = 'Please enter your Last Name.';
//} else if (!validate_name($bdate)) {
//    $response['error'] = 1;
//    $response['field'] = 'birth_date';
//    $response['message'] = 'Please enter your Birth Date.';
//} else if(!isset($sex)) {
//    $response['error'] = 1;
//    $response['field'] = 'sex';
//    $response['message'] = 'Please select your Sex.';
//} else if (!validate_name($addr)) {
//    $response['error'] = 1;
//    $response['field'] = 'address';
//    $response['message'] = 'Please enter your Address.';
} else if($action == 'new'){ 
    if (!validate_name($uname)) {
        $response['error'] = 1;
        $response['field'] = 'username';
        $response['message'] = 'Please enter your Username.';
    } else if (!validate_name($pword1)) {
        $response['error'] = 1;
        $response['field'] = 'password1';
        $response['message'] = 'Please enter your Password.';
    } else if (trim($pword1) != trim($pword2)) {
        $response['error'] = 1;
        $response['field'] = 'password2';
        $response['message'] = 'Password does not match.';
    } else if($privilege == 0) {
        $response['error'] = 1;
        $response['field'] = 'usertype';
        $response['message'] = 'Please select your User type.';
    } else{
        $this->m_admin->insert_account($_POST);
    }
} else {
//    if($privilege == 0) {
//        $response['error'] = 1;
//        $response['field'] = 'usertype';
//        $response['message'] = 'Please select your User type.'; 
//    } 
    $this->m_admin->update_account($_POST);
}

exit(json_encode($response));

/* ==================================================== */

function validate_name($field_name) {
    $fn = trim($field_name);

    if (!$fn)
        return 0;

    return 1;
}
?>
