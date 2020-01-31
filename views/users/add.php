<?php
/*  /users/add.php
 *  Handles the adding of new users to the database
 */
require_once("../../controllers/includes.php");


// Redirect to home page once added

// Check if all fields are filled
if( !empty( $_POST['username'] ) && 
!empty( $_POST['email'] ) &&
!empty( $_POST['password'] ) && 
!empty( $_POST['firstname'] ) &&
!empty( $_POST['lastname'] ) &&
!empty( $_POST['bio'] ) ) {
    
    // create a new user object
    $user = new User;
    
    // check if the user already exists in the database
    $exists = $user->exists();
    
    if( empty($exists) ) {
        // if not, add them to the database
        $new_user_id = $user->add();
        $_SESSION['user_logged_in'] = $new_user_id;
    } else {
        $_SESSION['create_account_msg'] = "<p class='text-danger'>User already exists</p>";
    }
}

if(!APP_DEBUG) header("Location: /");

?>